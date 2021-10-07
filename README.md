# Reset Course Completion

Moodle Reset Course Completion is an admin tool plugin, which resets course user’s grades from the gradebook. Multiple users can be selected at once to reset their grades. It resets manually added, hidden, overridden, excluded and locked grades. Even the grades that are associated with activity also gets deleted.

There is a filter for finding participants based on their firstname and surname. Also, there is a pagination option that will be visible if the number of students are equal to or more than twenty.

We are constantly improving the plugin, so stay tuned for upcoming versions.

## Features
- Filter participants by First name and Surname
- See all the user’s grades enrolled in a course
- Selecting one or multiple users to reset their grades
- Deletes manually added, hidden, overridden, excluded and locked grades including the grades that are associated with an activity


## Installation

### Install by downloading the ZIP file
1.  Download ZIP file from [GitHub Repository](https://github.com/eLearning-BS23/moodle-tool_resetcoursecompletion.git)
2.  Go to [Moodle directory]/admin/tool/
3.  Extract zip content in it
4.  In your Moodle site (as admin), Visit http://yoursite.com/admin to finish the installation


### Install using git clone
1.	Go to Moodle Project admin/tool directory
2.	clone code by using following commands
```
$ git clone https://github.com/eLearning-BS23/moodle-tool_resetcoursecompletion.git resetcoursecompletion
$ cd resetcoursecompletion 
```
3.	In your Moodle site (as admin), Visit http://yoursite.com/admin to finish the installation

For More Details, please see [Moodle's Docs page](https://docs.moodle.org/38/en/Installing_plugins) about installing plugin. 

## Download Source Code

To get the source code from GitHub, type

```
$ git clone https://github.com/eLearning-BS23/moodle-tool_resetcoursecompletion.git
```

## Usages
1.	Go to Site Administration -> courses -> Reset Course Completion
2.	Click on this menu item to view the reset course completion page

![View Reset Page](https://user-images.githubusercontent.com/40598386/136340473-d1895838-b642-4441-b8b9-9a2d2d24f79a.png)


## Configuration

You can install this plugin from [Moodle plugins directory](https://moodle.org/plugins) or can download from [Github](https://github.com/eLearning-BS23/moodle-tool_resetcoursecompletion/).

After installing the plugin, you can use the plugin by following:
> Select a course name for resetting the course participants grade

![Choosing Course](https://user-images.githubusercontent.com/40598386/136337871-819784a7-eb54-477b-87f3-12a3abab8757.png)

> Choose the participants whose grades you want to reset. You can choose as many as you want to

![Select Multiple Users](https://user-images.githubusercontent.com/40598386/136338285-5e3ef37b-b45d-4547-8094-c804ec4ee7d7.png)

> Give a confirmation for resetting the grades

![Confirm Reset](https://user-images.githubusercontent.com/40598386/136338481-2e71b05c-a264-4272-b8a3-3eae7106637f.png)

## Author
- [Brain Station 23 Ltd.](https://brainstation-23.com)

## License
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see [GNU License](http://www.gnu.org/licenses/).
