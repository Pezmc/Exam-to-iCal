#!/bin/bash
ids=(29 10 13 06 09)
n_elements=${#ids[@]}
let "max_index=$n_elements - 1"

if [ -e source ]
then 
  :
else
  mkdir "source"
fi
if [ -e "source/list1" ]
then
  rm source/*
fi
# Dowload buildings list
for i in `seq 0 $max_index`;
do
  curl "http://man-estates-fs5.ds.man.ac.uk/PSU/Building_Information/Building_List.aspx?CampID=S${ids[i]}" > "source/list$i";
done
# If we have correct permissions...
if [ -e "source" ]
then
  cd source
  if [ -e "temp" ]
  then
    rm "temp"
  fi
  # Get needed lines
  for i in `seq 0 $max_index`;
  do
    grep "href=\"Building" "list$i" >> "temp"
  done

  end="</font></td>"
  num=`cat <<< $end | wc -c`
  let "num=$num+1" 
  if [ -e "../buildings.txt" ]
  then
    echo "buildings.txt already exists... exiting"
    exit 0;
  fi
  # Convert line to just building name
  while read line
  do
    # Remove a load of stuff from the start
    thing=`cut -d "\"" -f 9 <<< "$line"`
    # Select everything but first character '>'
    thing=`cut -c 2- <<< "$thing"`
    # Remove string $end from thing.
    thing=`rev <<< $thing | cut -c $num- | rev`
    # Remove the word "building, as on mymanchester it doesn't add building; ie: Simon not Simon Building"
    thing=${thing%Building*}
    thing=${thing%building*}
    # Sackville street building is abbreviated on mymanchester.
    nostreet=${thing%Street*}
    if [ "$thing" == "$nostreet" ]
    then
      :
    else
      echo "$nostreet" >> "../buildings.txt"    
    fi
    echo $thing >> "../buildings.txt"
  done < "temp"
  # Clean up
  cd ../
  sed -i -e 's/^[ \t]*//' -e 's/[ \t]*$//' buildings.txt
  cat buildings.txt | uniq > temp
  cat temp > buildings.txt 
  rm temp
  rm source/*
  rmdir source
else
  echo "source folder doesnt exist, need write permissions."
fi