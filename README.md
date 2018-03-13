#Pretty URLs with a .htaccess file

## Pretty URLs
Most websites don't use URLs in the way we have so far. We are doing something like this
```
http://localhost/cit2318/wk14/details.php&id=3
```

Instead most professional PHP websites use 'pretty URLs' e.g. 
```
http://localhost/cit2318/wk14/details/3
```

Have a look at the guardian website http://www.theguardian.com or the bbc website http://www.bbc.co.uk as you navigate the site notice what the address bar shows. 

Pretty URLs look nicer, and are easier for users to remember. 

A typical pattern is to specify the name of the action (list, details, create, save etc.), and any parameters as the final parts of the URL. So in the above example, we are specifying an action of *details*, and passing a value of *3*. 

In order to get these nice looking URLs we have to tell the server to treat requests in a different way. We need a way of mapping between the nice looking URL the user enters and an actual PHP page on the server. 

## Using a .htaccess file
To do this we need to use a *.htaccess* file. **A *.htaccess* file is a configuration file for the server**. 

One of the things we can specify in a *.htaccess* file is to replace the URL the user has entered with a different URL. Try the following:

Create two HTML page, *red.php* and *green.php*. In *red.php* simply enter the word 'red' in *green.php* simply enter the word 'green'. Save them in the same folder on the web server.

Create a new file in the same directory, name it *.htaccess* (you must name it correctly). Add the following

```
RewriteEngine on 
RewriteRule red.php green.php
```

In browser navigate to *red.php*. If it works, *green.php* should be displayed. The first line simple states that we want to re-write the URL, the second line specifies that all requests for *red.php* should be redirected to *green.php*.

> Note, we are configuring the server, this isn't PHP. 

Create a new PHP page, name it *index.php*. Add a simple echo statement to test it works. Save it in the same folder as your *.htaccess* file. 

Modify the *.htaccess* file. Add the following rewrite rule:
```
RewriteEngine on 
RewriteRule ^(.*)$ index.php
```

This specifies that any URL, will be re-directed to *index.php*. **^(.\*)$**  is a regular expression that matches any character 

Test this works. It shouldn't matter what you enter after the directory name, you should be redirected to *index.php*.

## Routing - Mapping The URL to Actions
Typically we would map the URL the user enters to actions. To do this we will use PHP's string functions to break apart the URL so we can identify the action, parameters etc. 

### Splitting the string
Add the following at the top of index.php (You will need to change the values for *$basePath* so they match your directory structure)

```
$basePath="/CIT2318/using-htaccess/";

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
echo "<p>Action = ".$action."</p>";
```

> There are lots of echo statements in here. Have a good look at this output and make sure you understand what it does. 

### Mapping to a PHP page

Use this action value to specify a php page to load e.g.

```
if($action == "red"){
    require_once("red.php");
}else if($action == "green"){
    require_once("green.php");
}
```

Test this works. You should be able to enter a URL such as 

```
http://localhost/CIT2318/using-htaccess/red
```

And *red.php* should be displayed.

> Really what we have done here is a simple version of the front controller pattern. See the practical from week 17 for more info. 

### Using parameters

It would be nice if we could enter a URL such as
```
http://localhost/CIT2318/using-htaccess/green/
```
