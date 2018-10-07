<p>Dear John!</p>
<p>I developed this Api for you. Now you can read the latest tweets by Elon Musk, Donald J. Trump and other Twitter celebrities in real-time.</p>
<p>Api was wroten on pure PHP w/o any frameworks.</p>
<br/><br/>
<p>To use this Api you must run the installer using Cli:</p>
<pre>$ php {DOCUMENT_ROOT}/cli/install.php</pre>

<p>Or do a manual installation:</p>
<pre>mysql -u username -p password<br/>
CREATE DATABASE api_test;<br/>
USE api_test;<br/>
CREATE TABLE users (id int(11) unsigned not null auto_increment, screen_name varchar(32) not null, name varchar(64) not null, primary key (id), unique key udx_name (screen_name));</pre>
<br/><br/>
<p>System requirements:</p>
<ul>
    <li>Apache 2.4</li>
    <li>PHP 7.X</li>
    <li>MySQL 5.6</li>
</ul>
<br/>
<p>If you have troubles using this Api or found any bugs - tell me about this.</p>
<p>Enjoy!</p>
<br/><br/>
<p>
Regards, Alex<br/>
Software developer</p>