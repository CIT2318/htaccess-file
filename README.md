#Pretty URLs with a .htaccess file

Most websites don't use URLs in the way we have so far. We are doing something like this
```
http://localhost/cit2318/wk14/index.php?action=details&id=3
```

Instead most professional PHP websites use 'pretty URLs' e.g. 
```
http://localhost/cit2318/wk14/details/3
```

Have a look at the guardian website http://www.theguardian.com, as you navigate the site notice what the address bar shows. 

Pretty URLs look nicer, and are easier for users to remember. 

A typical pattern is to specify the name of the action, and any parameters as the final parts of the URL. So in the above example, we are specifying an action of *details*, and passing a value of *3*. 

In order to get these nice looking URLs we have to tell the server to treat requests in a different way. We need a way of mapping between the nice looking URL the user enters and an actual PHP page on the server. 

To do this we need to use a *.htaccess* file. A *.htaccess* file is a configuration file for the server. 

One of the things we can specify in a *.htaccess* file is to replace the URL the user has entered with a different URL. Try the following:

Create two HTML page, *red.html* and *green.html*. In *red.html* simply enter the work 'red' in *green.html* simply enter the word 'green'. Save them in the same folder on the web server.

Create a new file in the same directory, name it *.htaccess* (you must name it correctly). Add the following

```
RewriteEngine on 
RewriteRule red.html green.html
```

In browser navigate to *red.html*. If it works, *green.html* should be displayed. The first line simple states that we want to re-write the URL, the second line specifies that all requests for *red.html* should be redirected to *green.html*.

> Note, we are configuring the server, this isn't PHP. 

Open your copy of the front controller example we looked at in last week's seminar. Or download a copy from https://github.com/CIT2318/htaccess-file.

Add a *.htaccess* file in the same folder as *index.php*. Add the following rewrite rule:
```
RewriteEngine on 
RewriteRule ^(.*)$ index.php
```

This specifies that any URL, will be re-directed to *index.php*. **^(.\*)$**  is a regular expression that matches any character 

Test this works. It shouldn't matter what you enter after the directory name, you should be redirected to *index.php*.

##Routing - Mapping The URL to Actions
We need to do map the URL the user enters into actions for our controllers to carry out. To do this we will use PHP's string functions to break apart the URL so we can identify the action, parameters etc. 

Add the following at the top of index.php (You will  need to change the values for *baseURL* and *$basePath* so they match your directory structure)

```
$baseURL="http://localhost/CIT2318/htaccess/";
$basePath="/CIT2318/htaccess/";

//get full path of current URL
$url=$_SERVER["REQUEST_URI"]; 
echo "<p>URL: $url</p>";

//get the end components of the path
$shortPath = substr($url, strlen($basePath)); 
echo "<p>Short path: $shortPath</p>";

//split this string using '/' as a delimiter
$urlArray=explode("/", $shortPath); 
print_r($urlArray);

//the first element in the array is the action to use
$action=$urlArray[0];
echo "<p>$action</p>";
```

> There are lots of echo statements in here. Have a good look at this output and make sure you understand what it does. 

Finally, we can use this value to specify an action for the switch statement. The final *index.php* page looks like the following:

```
require_once("models/film-model.php");
$baseURL="http://localhost/CIT2318/htaccess/";
$basePath="/CIT2318/htaccess/";

//get full path of current URL
$url=$_SERVER["REQUEST_URI"]; 
echo "<p>URL: $url</p>";

//get the end components of the path
$shortPath = substr($url, strlen($basePath)); 
echo "<p>Short path: $shortPath</p>";

//split this string using '/' as a delimiter
$urlArray=explode("/", $shortPath); 
print_r($urlArray);

//the first element in the array is the action to use
$action=$urlArray[0];
echo "<p>$action</p>";

if ($action==="list") {
	$films=getAllFilms();
	$pageTitle="List all films";
	include("views/list-view.php");
} else if ($action==="details" && isset($urlArray[1])) {
	$film=getFilmById($urlArray[1]);
	$pageTitle="Film details";
	include("views/details-view.php");
} else {
    include("views/404-view.php");
}
```

Again, test this works. You should be able to enter a URL such as 

```
http://localhost/CIT2318/htaccess/details/4
```

Add the URL should be mapped to the *details* action.

##Getting the links to work
We need to change the hyperlinks so that they use the new URL format. Open *list-view.php*. Modify the echo statement that outputs a hyperlink that looks like the following

```
echo "<a href='".$baseURL."details/".$film['id']."'>";
```

Check this works. Now, when the user clicks on a film in the list, the details for the film should be displayed.

Finally change the navbar.inc.php so that the link back to the list of films also works.
