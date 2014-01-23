#!/usr/bin/env bash

if [ -d ~/.git-templates ]; then
    echo "Seems to be installed already"
    exit
fi

mkdir ~/.git-templates
git config --global init.templatedir ~/.git-templates
touch ~/.git-templates/pre-commit
chmod 777 ~/.git-templates/pre-commit
currentDir=$(pwd)
echo "#!/usr/bin/env bash" > ~/.git-templates/pre-commit
echo "$currentDir/bin/ah-php-git-hooks" >> ~/.git-templates/pre-commit


