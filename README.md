# Pretty URLs with a .htaccess file

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

Download this repository and put it on a server. Make sure you can view *red.php*, *green.php* and *blue.php*. 

Create a new file in the **root** of this folder (not in the pages folder), name it *.htaccess* (you must name it correctly). Add the following

```
RewriteEngine on 
RewriteRule pages/red.php pages/green.php
```

In browser navigate to *pages/red.php*. If it works, *pages/green.php* should be displayed. The first line simple states that we want to re-write the URL, the second line specifies that all requests for *pages/red.php* should be redirected to *pages/green.php*.

> Note, we are configuring the server, this isn't PHP. 

This is fairly pointless. Usually we would create a single PHP page (a front controller) that all requests will go to. Create a new PHP page in the same folder as your .htaccess file, name it *index.php*. Add a simple echo statement to test it works. 

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
echo "<p>Base Path: ".$basePath."</p>";

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
* Test this works. Experiment with specifiyng different URLs. See what happens. 

> There are lots of echo statements in here. Have a good look at this output and make sure you understand what it does. 

### Mapping to a PHP page

Use the action value to specify a php page to load e.g.

```
if($action == "red"){
    require_once("pages/red.php");
}else if($action == "green"){
    require_once("pages/green.php");
}
```

Test this works. You should be able to enter a URL such as 

```
http://localhost/CIT2318/using-htaccess/red
```

And *pages/red.php* should be displayed.

> Really what we have done here is a simple version of the front controller pattern. See the practical from week 17 for more info on this design pattern. 

### Using parameters

It would be nice if we could enter a URL such as:
```
http://localhost/CIT2318/using-htaccess/blue/20/3
```
And *blue.php* would be displayed telling us the total of 20+3 i.e. *The total of 20 and 3 is 23*.

Modify *index.php* and *blue.php* so that the user can specify which numbers should be added, as parameters in the URL. 