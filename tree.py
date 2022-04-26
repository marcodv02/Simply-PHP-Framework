#import os.listdir, os.path.isdir
from os import listdir, path as pathh


def tree(path):
    dirs= listdir(path)
    for i in range(len(dirs)):
        dirs[i]= path+"/"+dirs[i]
    for i in dirs:
        num_tabs= i.count("/")-1
        print(num_tabs*"\t", end="")
        if (pathh.isdir(i)):
            print(i+":")
            tree(i)
        else:
            print(i)
