from glob import glob
to_write= ""
def translate_framework(f, dt="", repl= []):
    patterns= []
    """[['<script src="', '" crossorigin="anonymous"></script>'],
    ['<rcript src="','"></script>'],
    ['<link href="','" rel="stylesheet" type="text/css" />'],
    ['<rink href="', '" rel="stylesheet" />']
    ]"""
    #[['<rel="sylesheet" href="', '" media="all">']]# [['<link href="', '" rel="stylesheet">'], ['<script src="', '"></script>']]
    for pattern in patterns:
        i= 0
        to_write= ""
        while (i<len(f)):
            to_write+= f[i]
            i+= 1
            #print(f[i:i+len(pattern[0])], end="\t")
            #print(pattern[0])
            if f[i:i+len(pattern[0])]==pattern[0]:
                #print(f[i:i+len(pattern[0])], end="\t")
                #print(pattern[0])
                #to_write+= pattern[0]
                i+= len(pattern[0])
                to_write+= '<?php $Sito->asset("'+dt
                buf= ""
                while f[i:i+len(pattern[1])]!=pattern[1]:
                    print(f[i], end="")
                    buf+= f[i]
                    i+= 1
                print("domodossola")
                if repl:
                    buf= buf.replace(repl[0], repl[1])
                i+= len(pattern[1])
                to_write+= buf
                to_write+= '");?>'
                #to_write+= pattern[1]
        #f= to_write
        f= to_write
    
    patterns= [['url(', ')'], ['src="', '"']]

    for pattern in patterns:
        i= 0
        to_write= ""
        while (i<len(f)):
            to_write+= f[i]
            i+= 1
            #print(f[i:i+len(pattern[0])], end="\t")
            #print(pattern[0])
            if f[i:i+len(pattern[0])]==pattern[0]:
                #print(f[i:i+len(pattern[0])], end="\t")
                #print(pattern[0])
                to_write+= pattern[0]
                i+= len(pattern[0])
                to_write+= '<?php echo $Sito->asset("'+dt
                buf= ""
                while f[i]!=pattern[1]:
                    print(f[i], end="")
                    buf+= f[i]
                    i+= 1
                print("trento")
                if repl:
                    buf= buf.replace(repl[0], repl[1])
                to_write+= buf
                to_write+= '");?>'
                #to_write+= pattern[1]
        #f= to_write
        f= to_write
    
    

    return f


for name in glob(input("path:\t")+"/*.html"):
    f= open(name).read()
    print(translate_framework(f))
    php_name= name.replace(".html", ".php")
    wr_file= open(php_name, "w")
    wr_file.write("<?php\n$Sito= new Foreground;\n?>")
    wr_file.write(translate_framework(f, ""))
    wr_file.close()
    #open(name.replace(".html", ".php"), "w").write(translate_framework(f, ""))

