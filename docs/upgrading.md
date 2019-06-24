# Upgrading

Upgrading your PiPass installation is a relatively easy process and will take 2 to 5 minutes depending on your experience with Linux and the ``git`` version-control system. Bear in mind that if you are upgrading from version 1.3 or lower, the update command will **break** your PiPass installation until you complete the upgrade process. This Wiki article will guide you through that whole process.

## Beginning the Upgrade

First, start by initiating the upgrade. Execute ``bash <(wget -qO- https://kubrick.roen.us/pipass/scripts/install.sh) `` and answer the prompts.

### Checking for Conflicts

Now, let's see if we are done. Execute this following command: ``cat /var/www/config.php | grep \<\< ``

#### If there is no output returned

Lucky you! There were no conflicts, and you are probably done with the upgrade. Head to the blockpage and make sure it's intact. If the blockpage is not showing up, run ``git diff --name-only --diff-filter=U | grep --invert-match setup/`` and follow the directions listed below on the files listed.

#### If there is an output returned

If the command _does return an output:_ it's likely that we've encountered a merge conflict. To someone who hasn't had a lot of experience with ``git``, this can sound daunting, but it isn't. All it means is that PiPass code has been updated as well as the code on your system. All you have to decide is which code **stays**. Follow the instructions below to resolve this conflict.

## Resolving Merge Conflicts

> If you are inexperienced with ``git``, we reccomend you copy your configuration files into a program such as Visual Studio Code which can help you deal with merge conflicts very easily and intuitively.

1\. Open ``config.php`` in your favorite text editor, and find the part that looks like this:
```
<<<<<<< Updated upstream
$conf['blockpage_url'] = get_config('blockpage_url', "blockpage/index.php");
=======
$conf['blockpage_url'] = "https://172.16.64.31/blockpage/";
>>>>>>> Stashed changes
```
2\. Remove the lines which contain ``<<<<<<<`` and ``>>>>>>>``. The top line is the new code from PiPass, and the bottom line is the code that was on your system. Your job, now, is to **merge** these lines of code. For this example, the merge result would look like:

``
$conf['blockpage_url'] = get_config('blockpage_url', "https://172.16.64.31/blockpage/");
``