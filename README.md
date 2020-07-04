![This project is currently in development. It may not be working as of now. Please wait until a stable version has been built and released.](https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master/.github/RESOURCES/powerhouse-indev.png)
***This project is currently non-functional. It does not yet have download or upload capabilities.***

Powerhouse is a customizable PHP-based file distribution program.

![Powerhouse banner](https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master/.github/RESOURCES/powerhouse-banner-narrow-on_blue.png)

![Demonstration picture 1](https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master/.github/RESOURCES/demo-1.png)
![Demonstration picture 2](https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master/.github/RESOURCES/demo-2.png)
![Demonstration animation](https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master/.github/RESOURCES/demo-anim-1.gif)

*Planned* Features:
* Informative upload panel
* File previews
* Instant download
* Security and authorization
* Material design

## Themes
Without any theme to use, Powerhouse will look extremely terrible, and basic functionality is extremely limited. Powerhouse relies on a theme to provide a working interface.

Theoretically, a user can even replace the `/interface` folder with their own custom interface. However, this is discouraged unless you trust the creator of said interface.

By default, Powerhouse uses a modified Google Material theme. This modern yet simple look makes it easy to use no matter which user.

## Files
By theory, you could delete every file except `.htaccess`, `const.php`, and `env.php` and every folder except `api` and `system`, and Powerhouse will still work fine.

The interface mostly depends on the API, so as long as the skeletal files and folders exist, Powerhouse will still work.

This opens up the opportunity for anyone to create their own Powerhouse interface as a fork of the project. So, go ahead and do it better than me if you can!

## Contributing
Although I'm still building the entire project, you can see what the folders are for in [the repository guide](https://github.com/ChlodAlejandro/powerhouse/blob/master/WHAT-IS-THIS-FOR.md).

## Technical
Powerhouse was built and tested exclusively on PHP 7.3.1 (x86, thread safe) using Apache 2.4 on a Windows system. It may not work for other instances of PHP as of now.

Powerhouse aims to be compatible no matter what operating system the webserver is installed on.

## License 
This entire repository, including the source code, unless otherwise explicitly stated in the LICENSE file in a folder or by the file itself, is under the [Apache License, v2.0](https://github.com/ChlodAlejandro/powerhouse/blob/master/LICENSE).