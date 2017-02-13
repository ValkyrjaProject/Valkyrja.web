## Contributors:

As a contributor you can directly commit to the project. Please create a new branch for everything, and then submit pull-request. This is done easily right here on the page if you're not awesome enough in the CLI.

1. Create a new branch. This can be done easily on github. [e.g.](https://i.imgur.com/EDtnZ56.png)
  1. Naming convention: `<type of branch>-<name of your contribution>` where
    * `<type of branch>` is generally either `feature`, `improvement` or `fix` (similar to issue labels)
    * `<name of your contribution>` would e whatever your code is going to be about, where it should use camelCase. In case of an issue, just add the ticket number.
  2. Examples:
    * `feature-commandOverrides` (without an issue)
    * `improvement-123-youtubeNotifications` (for issue `#123`)
    * `fix-123` (for issue `#123`) _Please don't use **just** the number for bigger features, add some title to know what's that about without having to look it up._
2. Commit your code properly into your branch as you work on it.
  1. Recommended IDE/editor to write your code:
    * Any IDE or editor that follows keeps track of PSR-2 issues and corrects autoloading to PSR-4
  2. Discuss your problems and ideas with our awesome dev team on Discord, to further improve them!
3. Document and test your code
  1. Follow the standards of [PHPDoc](https://phpdoc.org) when documenting methods.
  2. Test your code either through hosting the website yourself or by using PHPUnit tests. The latter is not required but preferred, if unit tested please add the tests with the commit.
4. Submit Pull Request when you're done. This can be done easily on GitHub. e.g. [1.](https://i.imgur.com/vF1uSMm.png) [2.](https://i.imgur.com/mbNvr3c.png)
  1. New features or improvements or any other large changes should go into the `dev` branch.
  2. Really tiny fixes and typos, or tiny improvements of a response message, etc, can go straight into `master`. If in doubt ask.
  3. If there is an issue for your PR, make sure to mention the `#number` in the title.

### Outside contributors:

The workflow for outside contribution is recommended to be the same, we don't bite :P

The only difference is that you would first fork the repository, then follow all the other stuff and eventually submit a PR from your fork, into our appropriate branch.

## Code style and Naming Conventions

Just a few guidelines about the code:

* Follow [PSR-4](http://www.php-fig.org/psr/psr-4) and [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) when coding PHP code
* Use 4 spaces for indentation when editing SCSS
* Use Laravel Elixir with Webpack for JavaScript modules.
 
Please try to set-up your IDE to handle this for you:

* Autoloader styling [PSR-4](http://www.php-fig.org/psr/psr-4)
* Coding style guide [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
