# CakePHP + fullCalendar = CakeFullCalendar

CakeFC は jQuery のカレンダーアプリを実現するプラグイン
[fullCalendar](http://arshaw.com/fullcalendar/) と
CakePHP を使ってカレンダーアプリを実装する。
CakePHP の fullCalendar 実装を目指す。

## Deploy Cakephp On HEROKU
Heroku's not just for Rails anymore, folks. If you're more PHP-in-clined and
learn toward frameworks such as CakePHP, you might enjoy trying Heroku's current
Celadon Cedar stack as your platform.

Here I'll step through the Blog Tutorial in the CakePHP Cookbook, with the few
extra steps needed to get it running on Heroku. As prerequisites, you should be
familiar with this tutorial in its generic form, and with the basics of using
Heroku.

Obviously, if you're baked some Cake before, you only need to look at the Heroku
parts. And if you're comfortable with both CakePHP and Heroku, just skip to the
steps about the database configuration.

The section titles below match those in the Blog Tutorial. I'm not going to
reproduce that tutorial in detai, but if you need more explanation, you can
follow along there.

## Getting Cake
Heroku works using git, so the first task is to create a git repository
containing the CakePHP code.

The Cake developers also use git to write Cake itself, so there is a catch to be
aware of. The .gitignore file that comes with Cake is set to exclude /app/Config
and /app/tmp. Because the app will need those directories, the corresponding
lines need to be removed from .gitignore. However, files put in tmp during
testing shouldn’t be included, so a separate .gitignore needs to be added inside
tmp, containing a wildcard followed by a negated list of everything that’s there
now. My description is probably a bit confusing, so I’ll illustrate with an
example of what app/tmp/.gitignore should end up looking like:
