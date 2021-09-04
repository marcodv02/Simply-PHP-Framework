# Simply-PHP-Framework
I want promote this framework. It'll be hopefull to reduce html and css code, I want to transform html languange in a PHP language. It use MVC pattern.
You need just to execute makewebsite.py script to build a directory for your website.
If u've already written html code you can import it in website/view/ and translate using import_websites.py, it'll edit your links to asset in absolute link using the class Foreground.

The website contains this folders:
api: //Will contain your api to get a response for a call
view: //Will contain your foreground website
	view/admin: //Foreground admin panel
	view/index.php //Example index
.htaccess //Convert page name to get value
element: //Where u put your constant elements, for example navbar, sidebar and ect.
	element/element.php //An example
index.php //Index page to redirect all using get page value
configuration.php //Import it to get configuration about classes and database
asset: //This directory contains all your assets
  asset/media: //It'll contain your media files
	asset/js: //Js files
		asset/js/bs: //Bootstrap javascript files got by utils directory (U can remove it)
		asset/js/jquery-3.6.0.js //Jquery file got by utils directory (U can remove it)
		asset/js/page_script: //Contains custom single js file for any page 
			asset/js/page_script/admin: //Js files for admin pages
	asset/css: //Css files
		asset/css/page_style: //Contains custom single css file for any page 
			asset/css/page_style/admin: //Css files for admin pages
		asset/css/bs: //Bootstrap css files got by utils directory (U can remove it)
Controller:
	Controller/Server.php //Contains the classes Foreground and Background.
  
  
Foreground methods:
  title($title_name) //Echo of <title>$title_name</title>
  asset($relative_path) //Include js/css/media files for example .js file relative_path become echo <script src="website/asset/js/$relative_path"></script>, media files use return not echo
  view($relative_path) //Show your page, the path begin at website/view
  Others are working in progress
Background methods:
  edit($filter, $data, $table) change rows of a table selected by filter and change then using $data=["column"=>"new_value"]
  insert($data, $table) add a row with data values using the key as column name and value as the value of the table
  show_all($filter, $table) return an array of rows filtered by $filter
  query($sql) exec the query
  get_last_query() return the last query
