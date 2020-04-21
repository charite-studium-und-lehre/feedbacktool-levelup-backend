#!/usr/bin/env bash


cd `dirname $0`/..
echo

#bin/executeTestMigrations.sh

CURL_STRING=`echo "<?php echo function_exists('curl_version') ? 'Enabled' : 'Disabled';"|php;`
if [ $CURL_STRING = "Disabled" ]; then
    cat /etc/issue|grep "Ubuntu" > /dev/null
    if [ $? -eq 0 ]; then
        echo Installing php-curl extension
        sudo apt install php-curl
    else
        echo  "Please install PHP curl extension to run phive!"
    fi
fi

if [ -z `which phive` ]; then
    echo Installiere "Phive" von http://phar.io

    wget -O phive.phar https://phar.io/releases/phive.phar
    # wget -O phive.phar.asc https://phar.io/releases/phive.phar.asc
    # gpg --keyserver hkps.pool.sks-keyservers.net --recv-keys 0x9D8A98B29B2D5D79
    # gpg --verify phive.phar.asc phive.phar
    # rm phive.phar.asc
    chmod +x phive.phar
    sudo mv phive.phar /usr/local/bin/phive

    phive install --trust-gpg-keys
fi
phive update

which plantuml > /dev/null
if [ $? -ne 0 ]; then
    cat /etc/issue|grep "Ubuntu" > /dev/null
    if [ $? -eq 0 ]; then
        echo Installing PlantUML
        sudo apt-get install plantuml
    else
        echo  "Please install plantUML to run dephpend!"
    fi
fi

#ls bin/tools/deptrac > /dev/null 2>/dev/null
#if [ $? -ne 0 ]; then
    echo "Installiere deptrac"
    curl -LS http://get.sensiolabs.de/deptrac.phar -o deptrac.phar
    chmod +x deptrac.phar
    mv deptrac.phar bin/tools/deptrac

    cat /etc/issue|grep "Ubuntu" > /dev/null
    if [ $? -eq 0 ]; then
        echo Installing graphviz
        sudo apt-get install graphviz
    else
        echo  "To run deptrac on osx + brew, run:   brew install graphviz"
    fi
#fi


echo -e "\e[32mDEV TOOLS: \e[0m"
#echo "bin/runAllTests.sh"
echo "bin/domainDependencies.sh"
echo "bin/tools/deptrac"
echo "bin/checkDuplications.sh"


# tools/deptrac self-update
