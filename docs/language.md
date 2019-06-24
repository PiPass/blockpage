# Languages

PiPass comes with a few languages right out of the box. You can see if your language is natively supported by running ``ls <webroot>/locale | grep locale-xx``. Replace ``xx`` with your language's [ISO 639-1](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) code. If the command returns an output, the language has been added to PiPass by another contributor and is ready for you to use. If not, the language is unavailable, but you can [make it available](#adding-a-language).

# Selecting a Language

The default language of PiPass is English due to the vast majority of PiPass users natively speaking English. To select a new language, open PiPass' ``config.php`` file in your favorite text editor, and locate the following line:

``$conf["language"] = get_config('language', "en");``

Change ``en`` to your language's ISO 639-1 code, save the file, and attempt to visit a blocked website.

> You may need to clear your browser's cache for the changes to update.

# Adding a Language

Languages are crucial to the accessibility and global usefulness of PiPass, and we rely on people who can speak several languages to help translate the software.

First, begin by [forking the repository](https://github.com/roenw/PiPass) into your own GitHub account. It will usually be simpler to complete this guide through the GitHub web interface, but you can clone your fork on to your computer and edit off of there, if you would like to.

After you do that, 