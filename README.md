# enhanced-contactform

The enhanced Contact form adds the following functionality to the contactform:
* Modules page for adding, deleting emailadresses to be used in the contactform, Displayname and Emailadres
* Selector for the configured emailadresses on the site
* Captcha implementation of https://github.com/yasirmturk/simple-php-captcha


# Usages Prerequisites
In a previous version a .htacces file was added to the modules folder. this file needs to be removed.

To have a nice error message which is instantly visible add the following code to the Style sheet of your theme:
<pre>
p.error {
    line-height: 180%;
    color: black;
    font-size: 20px;
    border: 2px red solid;
    border-radius: 20px;
    padding-left: 20px;
    max-width: 200px;
    margin-bottom: 20px;
    background-color: lightpink;
}

p.success {
    line-height: 180%;
    color: black;
    font-size: 20px;
    border: 2px green solid;
    border-radius: 20px;
    padding-left: 20px;
    max-width: 200px;
    margin-bottom: 20px;
    background-color: lightgreen;
}
</pre>
