# Powerhouse Theme

Make your Powerhouse installation more beautiful by installing custom themes! (assuming that the current theme is too mediocre for you)

Themes are usually packed in `.zip` files and are extracted here. All the CSS files usually begin with the prefix `theme_`. to indicate that it is a themed CSS file.

**Please note that without a theme, Powerhouse will look disgustingly bad. Powerhouse is not only functionality-centered, but also heavily aesthetic-centered.**

## Making a theme
To make a theme, simply replace the rules in the pre-installed "`theme_material`" theme. Make sure to append a "`theme_`" before the name of your theme.

For every theme, there must be the following files or folders. Without these files, the interface will be terrible.

* `theme_global.css` - The global CSS stylesheet. This stylesheet is loaded in every page of Powerhouse.
* `theme_icons.css` - The definition for your icons. In case you prefer to use a font for icon resolution, use this stylesheet. Otherwise, you can skip this.
* `theme_files.css` - The rules for the files section of the main page.
* `theme_dialog.css` - The rules for every dialog in Powerhouse. This governs the look of everything from basic boxes to the upload form..
* `theme_action_panel.css` - The rules for the action panel, the header of the Powerhouse main page.
* `scripts/` - A folder containing optional scripts run during certain page load events. This is where you can convert standard elements with `icon` classes into your own elements.
* `scripts/global.js` - The global JavaScript script file. This file is run in every page of Powerhouse.

In case your only intention is to modify the default colors of Powerhouse from its normal blue to another color like red, then you can simply modify the variables in the `theme_global.css` of the `material` theme.