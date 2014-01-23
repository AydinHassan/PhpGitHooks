#!/usr/bin/env bash

if [ -d ~/.git-templates ]; then
    echo "Seems to be installed already"
    exit
fi

mkdir -p ~/.git-templates/hooks
git config --global init.templatedir ~/.git-templates
touch ~/.git-templates/hooks/pre-commit
chmod 777 ~/.git-templates/hooks/pre-commit
currentDir=$(pwd)
echo "#!/usr/bin/env bash" > ~/.git-templates/hooks/pre-commit
echo "$currentDir/bin/ah-php-git-hooks" >> ~/.git-templates/hooks/pre-commit
echo "Done!\n"
echo "Any new repositiories will use the hooks provided with this package\n"
echo "For existing repositories you should run 'git init' in the root before doing any commits\n"
echo "Big brother is watching your codez....\n"


