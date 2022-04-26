from build_website import builder

project= ""
def main(website):
    project= ""
    if ((website.project)and(website.project[0]!="@")):
        project= "@"+website.project
    sb= "simplybuilder"+project+": "
    shell= input(sb)
    website.command(shell)

if __name__=="__main__":
    website= builder()
    website.version()
    website.load()
    while website.shell:
        main(website)
