import json, sys, os, shutil

class builder:
    _V= 0.02
    project= ""
    projects= {}
    current_website= {}
    shell= 0
    def __init__(self):
        self.shell= 1
    def version(self):
        print(self._V)
    
    def command(self, cmds):
        commands= cmds.split(";")
        for cmd in commands:
            cmd= cmd.lower().strip(" ").split(" ")
            if cmd[0]=="begin":
                print("Starting your project")
                if len(cmd)>1:
                    self.projects[cmd[1]]= {"rules": ""}
                    self.command("use "+cmd[1])
            elif cmd[0]=="create":
                if (self.project):
                    print("Creating your website")
                
                    conf= ["", "name", "db_host", "db_user", "db_pw", "db_name"]
                    self.current_website["settings"]= {"name": self.project, "db_host": "localhost", "db_user": "marco", "db_pw": "36056", "db_name": "test"}
                    for i in range(1, len(cmd)):
                        self.current_website["settings"][conf[i]]= cmd[i]
                    print(self.current_website)
                    self.projects[self.project]["settings"]= self.current_website["settings"]
                else:
                    print("Before creating website, begin a project o use a project")
            elif cmd[0]=="add":
                for word in cmd:
                    self.projects[self.project]["rules"]+= " "+word
                self.projects[self.project]["rules"]+=";"
                print("Add item to your website")
            elif cmd[0]=="use":
                if len(cmd)>1:
                    if cmd[1] in self.projects:
                        self.project= cmd[1]
                    else:
                        print("The project doesn't exist")
            elif cmd[0]=="available":
                print(self.projects)
                print("List of available projects")
                for i in self.projects:
                    print("Project: "+i)
            elif cmd[0]=="exit":
                print("Get out")
                self.shell= 0
            elif cmd[0]=="get":
                print("got")
                self.get()
            elif cmd[0]=="help":
                print("help\nexit\nget\nbegin [project_name]\ncreate [name] [host_db] [user] [password] [db_name]\navailable\nuse\nbuild\nadd [compontent/element]")
            elif cmd[0]=="build":
                if ((self.project)and("settings" in self.projects[self.project])):
                    print("Building beta site")

                    setting= self.projects[self.project]["settings"]
                    rules= self.read_rules(self.projects[self.project]["rules"])
                    if not("element" in rules["adds"]):
                        rules["adds"]["element"]= []
                    if not("component" in rules["adds"]):
                        rules["adds"]["component"]= []
                    
                    self.build(setting["name"], setting["db_host"], setting["db_user"], setting["db_pw"], setting["db_name"], rules["adds"]["element"], rules["adds"]["component"])
                    #print(self.projects[self.project])
                    #self.build(self.project)
                else:
                    print("Use a project before building it, and create website")
            elif cmd[0]=="translate":
                print("Building alfa site")
            else:
                print("Not recognized command")
        self.write()
    def read_rules(self, rules):
        arr= {"adds": {}}
        for rule in rules.split(";"):
            sp_rule= rule.strip(" ").split(" ")
            print(sp_rule)
            if sp_rule[0]=="add":
                s= " ".join(sp_rule[2:])
                if sp_rule[1] in arr["adds"]:
                    arr["adds"][sp_rule[1]].append(s)
                else:
                    arr["adds"][sp_rule[1]]= [s]
        return arr
    def get(self):
        if self.project:
            rules= self.projects[self.project]["rules"]
            for r in rules.split(";")[:-1]:
                rule= r.strip(" ")
                print(rule)
        else:
            print("Use a project before get options")
    def load(self):
        if os.path.exists("imp_simply_builder.json"):
            with open("imp_simply_builder.json", "r") as read_file:
                self.projects= json.loads(read_file.read())["projects"]
        else:
            self.projects= {}
    def write(self):
        data= {
                "projects": self.projects
        }
        
        with open("imp_simply_builder.json", "w") as write_file:
            json.dump(data, write_file)
    def build(self, website_name="test", db_host= "localhost", db_user="marco", db_pw="36056", db_name="test", elements=[], components=[]): #Build beta websitei
        dirs= ["asset", "view", "view/admin", "api", "Controller", "element"]
        asset= ["css", "css/bs", "css/page_style", "css/page_style/admin",
                "js", "js/bs", "js/page_script", "js/page_script/admin",
                "media"]
        if os.path.exists(website_name):
            rimuovo= input("Impossibile build sito già esistente, lo rimuovo? N/y").lower()
            if (rimuovo!="n"):
                shutil.rmtree(website_name)
                os.mkdir(website_name)
        else:
            os.mkdir(website_name)

        website_name+= "/"

        for i in dirs:
            os.mkdir(website_name+i)

        for i in asset:
            os.mkdir(website_name+"asset/"+i)

        for i in elements:
            if os.path.exists("utils/elements/"+i+".php"):
                shutil.copy("utils/elements/"+i+".php", website_name+"element/"+i+".php")
            else:
                print("Ops element "+i+" doesn't exist, I'll touch it")
                os.system("touch "+website_name+"element/"+i+".php")

        for i in components:
            if os.path.exists("utils/components/"+i+".php"):
                shutil.copy("utils/components/"+i+".php", website_name+"view/"+i+".php")
            else:
                print("Ops component "+i+" doesn't exist, I'll touch it")
                os.system("touch "+website_name+"view/"+i+".php")
        configuration= """<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define(\"HOST\", \"{db_host}\");
define(\"USER\", \"{db_user}\");
define(\"PASSWORD\", \"{db_pw}\");
define(\"DATABASE\", \"{db_name}\");

define(\"SERVERNAME\", \"{server_name}\");

if (session_status() === PHP_SESSION_NONE)
    session_start();

include_once \"Controller/Server.php\";""".format(
            db_host= db_host,
            db_user= db_user,
            db_pw= db_pw,
            db_name= db_name,
            server_name= website_name[:-1]
        )

        htaccess= """RewriteEngine On

RewriteCond %{REQUEST_FILENAME} /var/www/"""+website_name[:-1]+"""/page
RewriteRule ^page/(.*)$ index.php?page=$1 [NC,L]

RewriteCond %{REQUEST_FILENAME} /var/www/"""+website_name[:-1]+"""/admin
RewriteRule ^admin/(.*)$ index.php?admin=$1 [NC,L]

RewriteCond %{REQUEST_FILENAME} /var/www/"""+website_name[:-1]+"""/api
RewriteRule ^api/(.*)$ index.php?api=$1 [NC,L]
"""
        htaccess= """RewriteEngine On

RewriteCond %{REQUEST_FILENAME} /var/www/test/admin
RewriteRule ^admin/(.*)$ index.php?admin=$1 [NC,L]

RewriteCond %{REQUEST_FILENAME} /var/www/test/api
RewriteRule ^api/(.*)$ index.php?api=$1 [NC,L]

RewriteCond %{REQUEST_FILENAME} /var/www/test/
RewriteRule ^(.*)$ index.php?page=$1 [L,QSA]
"""
        index= """
<?php
include_once "configuration.php";

$Sito= new Foreground;
$page= "index";

if (isset($_GET["page"]))
    $page= $_GET["page"];//.".php";
elseif (isset($_GET["admin"])){
    if ($_GET["admin"]!="login"){
        if (!isset($_SESSION["UID"])){
            header("location:login.php");
        }
    }
    $page= "admin/".$_GET["admin"];
}elseif (isset($_GET["api"])){
    $page= "api/".$_GET["api"];
}
$Sito->view($page);
"""
        index= """<?php
include_once "configuration.php";

/*header('P3P: CP="CAO PSA OUR"');
session_set_cookie_params(['samesite' => 'None;Secure']);*/
$Sito= new Foreground;

if (isset($_GET["admin"])or(isset($_GET["api"])))
    unset($_GET["page"]);

if (isset($_GET["page"]))
    $Sito->view($_GET["page"]);
elseif (isset($_GET["admin"])){
    if ($_GET["admin"]!="login"){
        if (!isset($_SESSION["UID"])){
            header("location:login.php");
        }
    }
    $page= "admin/".$_GET["admin"];
    $Sito->view($page);
}elseif (isset($_GET["api"])){
    $Sito->api($_GET["api"]);
}elseif (isset($_GET["element"])){
    $Sito->element($_GET["element"]);
}else
    $Sito->view("index");
"""
        f= open(website_name+"configuration.php", "w")

        f.write(configuration)

        f.close()

        f= open(website_name+".htaccess", "w")

        f.write(htaccess)

        f.close()

        f= open(website_name+"index.php", "w")

        f.write(index)

        f.close()

        shutil.copy("utils/Controller/Server.php", website_name+"Controller/")
        shutil.copy("utils/index.php", website_name+"view/")
        shutil.copy("utils/element.php", website_name+"element/")
        for i in os.listdir("utils/assets/bs/css"):
            shutil.copy("utils/assets/bs/css/"+i, website_name+"asset/css/bs/")
        for i in os.listdir("utils/assets/bs/js"):
            shutil.copy("utils/assets/bs/js/"+i, website_name+"asset/js/bs/")
        shutil.copy("utils/assets/jquery-3.6.0.js", website_name+"asset/js/")

        website_name= website_name[:-1]
