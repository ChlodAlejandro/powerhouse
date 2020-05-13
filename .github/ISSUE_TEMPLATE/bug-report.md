---
name: Bug Report
about: Create a report detailing a bug you encountered while using Powerhouse
title: ''
labels: bug
assignees: ''

---

<!---
Hello, and thank you for choosing to report a bug today!

These comments will be your guide when writing your bug report. You
don't have to remove them, since these will not be shown in your final
report.

Follow the instructions carefully for us to properly attend to your report.
 --->
<!--
STEP 1a: Determining your Powerhouse installation.

==============================================
YOU CAN AUTOMATICALLY BUILD STEP 1a AND 1b WITH POWERHOUSE.
==============================================
Unless you are unable to run PHP CLI scripts, it is advised that you instead
use the issue writer, located at `/system/cli/issue_writer.php`, which will
automatically compose steps 1a and 1b for you. This will also create additional
information that may help us with your case.

Otherwise, for the following parts, please enter the requested value.
-->
<!-- AUTO WRITER START

If you used the issue writer, replace this comment, up until the `AUTO WRITER
STOP` block with the output provided by the auto-writer script.-->
## 1a: System Info
* **Web Server:** <!-- Please enter your web server name and version here (e.g. Apache 2.4) -->

* **PHP Info:**
<details>
<summary>PHP Info</summary>

```
<!-- Enter the output of the terminal command `php -r "phpinfo(INFO_GENERAL);"` here -->
```
</details>

## 1b: Powerhouse Info
* **Version:** <!-- Enter your Powerhouse version here -->
* **const.php tampered:** <!-- State if you modified your const.php file. (Yes/No) -->
* **env.php exists:** <!-- State if you have an installed env.php file. (Yes/No) -->

### const.php

<details>
<summary>const.php</summary>

```
<!-- Enter the contents of your const.php file here. -->
```
</details>

### env.php

<details>
<summary>env.php</summary>

```
<!-- Enter the contents of your env.php file here. -->
```
</details>
<!-- AUTO WRITER STOP -->

## 2: Issue Details
<!-- For the following, please replace the comments with what is being asked.-->

**Summary:** <!-- Please concisely state the issue you experienced here. -->

**Description:** <!-- Please describe, as accurately as you can, the issue that you experienced). -->

```
<!-- If you encountered an error message or exception stack, please place it here. -->
```

<!-- If you have any screenshots, please attach them as well. -->

## 3: Reproduction
<!-- Please exactly state what was done in order to get the error you found. If you do not know how did you encounter the error, simply put what you were last doing prior to the error. -->


<!-- ALL DONE! -->
<!-- Once you're done with writing your issue report, feel free to submit it. Someone from the Powerhouse team will be there to respond as soon as they're available. -->
