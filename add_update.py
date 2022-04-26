from datetime import date
import os, shutil, glob

today = date.today()
str_today= today.strftime("%d-%m-%Y")

path= input("Insert path of a updated example\n>>>")

s_name= path.split("/")[-1]
to_copy= ["api/*",
        "Controller/Server.php",
        "configuration.php",
        ".htaccess",
        "index.php"]
p_f_exists= []
for i in to_copy:
    g= glob.glob(path+"/"+i)

    if g:
        for k in g:
            if not(os.path.isdir(k)):
                p_f_exists.append(k)
    else:
        print("non esiste "+path+"/"+i)
print(p_f_exists)

def custom_copy(files, path_to_copy, c):
    if os.path.exists(path_to_copy+"/"+str(c)):
        custom_copy(files, path_to_copy, c+1)
    else:
        os.mkdir(path_to_copy+"/"+str(c))
        for i in files:
            shutil.copy(i, path_to_copy+"/"+str(c))
if os.path.exists("utils/updates/"+s_name+"_"+str_today):
    custom_copy(p_f_exists, "utils/updates/"+s_name+"_"+str_today, 1)
else:
    os.mkdir("utils/updates/"+s_name+"_"+str_today)
    for i in p_f_exists:
        shutil.copy(i, "utils/updates/"+s_name+"_"+str_today)

