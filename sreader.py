import urllib.request
website= "http://www.google.com"
page= urllib.request.urlopen(website).read()
page= page.decode("ISO-8859-1")
#for lines in page.readlines():
#    print(lines)
print(page)
data= []
i= 0;
def get_info_from_tag(tag_text):
    tag_text= tag_text.replace("<", "").replace(">", "")
    name= ""
    attr= []
    h= 0
    while ((h<len(tag_text))and(tag_text[h]!=" ")):
        name+= tag_text[h]
        h+=1
    attr_name= ""
    attr_val= ""
    b= False
    while h<len(tag_text):
        if ((tag_text[h]!=" ")or(b)):
            if ((tag_text[h]=="'")or(tag_text[h]=='"')):
                b= not(b)
            else:
                if (b):
                    attr_val+= tag_text[h]
                else:
                    if tag_text[h]!="=":
                        attr_name+= tag_text[h]
        else:
            if (attr_name!=""):
                attr.append([attr_name, attr_val])
            attr_name= ""
            attr_val= ""
        h+=1
    if attr:
        return [name, attr]
    else:
        return name
def get_tag(text):
    t= []
    h= 0
    while (h<len(text))and(text[h]!="<"):
        h+= 1
    b= h
    while (b<len(text))and(text[b]!=">"):
        b+= 1
    if (h==b):
        return ""
    return (h, text[h:b+1])
c= 0
while c<len(page):
    begin, tg= get_tag(page[c:])
    #print(len(tg))
    print(page[c:10])
    c+= begin+len(tg)
    if len(tg)==0:
        c+= 1
    else:
        print(get_info_from_tag(tg))


