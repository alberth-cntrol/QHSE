/*
 * ThemeGray by Ian Reyes and Heng Yuan
 */

var cmThemeGray =
{
	prefix:	'ThemeGray',
  	// main menu display attributes
  	//
  	// Note.  When the menu bar is horizontal,
  	// mainFolderLeft and mainFolderRight are
  	// put in <span></span>.  When the menu
  	// bar is vertical, they would be put in
  	// a separate TD cell.

  	// HTML code to the left of the folder item
  	mainFolderLeft: '',
  	// HTML code to the right of the folder item
  	mainFolderRight: '',
	// HTML code to the left of the regular item
	mainItemLeft: '',
	// HTML code to the right of the regular item
	mainItemRight: '',

	// sub menu display attributes

	// HTML code to the left of the folder item
	folderLeft: '>',
	// HTML code to the right of the folder item
	folderRight: '&lt;',
	// HTML code to the left of the regular item
	itemLeft: '&nbsp;',
	// HTML code to the right of the regular item
	itemRight: '&nbsp;',
	// cell spacing for main menu
	mainSpacing: 1,
	// cell spacing for sub menus
	subSpacing: 0,
	// auto dispear time for submenus in milli-seconds
	delay: 200

	// rest use default settings
};

// for sub menu horizontal explode
var cmThemeGrayHexplode = [_cmNoClick, '<td colspan="3" class="ThemeGrayMenuexplode"><div class="ThemeGrayMenuexplode"></div></td>'];
// for vertical main menu horizontal explode
var cmThemeGrayMainHexplode = [_cmNoClick, '<td colspan="3" class="ThemeGrayMenuexplode"><div class="ThemeGrayMenuexplode"></div></td>'];
// for horizontal main menu vertical explode
var cmThemeGrayMainVexplode = [_cmNoClick, '|'];
