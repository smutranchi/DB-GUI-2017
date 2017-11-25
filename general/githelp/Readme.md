# Git Command Resources

## Seung Ki Lee

This page is built and deployed using [Typora](https://typora.io/) and [Gitbook](https://www.gitbook.com). View in Rendered HTML in White Theme [On My Github](https://seungkileesmu.github.io/Github-Command-Resource/Git%20Command%20Resources-white.html).



This a post about Git Commands. I was supposed to learn it in my sophomore year of college, but I had no clear guidance or tutorial to start off of. My professor showed us one video of his TA using Git on comandline, and that was it. No more resource on Git. We had to submit one assignment via commandline for a grade, and after that almost everyone just used github website for GUI. Gotta love that drag and drop :)

But Commandline for Git is way too useful of a tool to just dismiss and move on: Have you ever tried uploading a project in PHP 100 files at a time via github website? What about uploading node_modules to github and ended up deleting the whole branch because you don't know how to get rid of a folder? Have you ever just dragged and dropped a file directly into master because you didn't know how to resolve merge conflicted pull requests? And overwritten a work that you and your team have to submit in another 3 hours? Have your friends looked at you with look of disgust in class because you wanted to use [Github for Desktop](https://desktop.github.com/)? (which is actually a great tool!) 

Because I have. All of those happened to me personally and I said enough is enough. By learning git commands, I was able to do a lot more in a lot less time. This is not only a help for people who wants to get started on learning Git and version control, but a reference for myself as well.

I will use Github as primary example for commands and references. For any other Git Repository, please contact me at seungkil@smu.edu or checkout their website listed at [Resources Section](#resource).

<a id="toc">

## Table of Contents

1. [Git Commands Cheatsheet](#cheatsheet) : :coffee: Basic and Quick Lookup for To-Go-Commands that you need.  
   1. [configure git email/name](#config)
   2. [make .gitignore](#gitignore)
   3. [make a new repo](#make-new)
   4. [clone a repo](#clone)
   5. [remote add origin](#remote)
   6. [pull from repository](#pull)
   7. [add, commit and push](#a-c-p)
   8. [branching](#branch)
   9. [merge](#merge)
2. [Git Tutorials](#tutorial) : :book: Materials to help you learn Git. Also the concept behind version controls.
   1. [Dont be afraid to commit](http://dont-be-afraid-to-commit.readthedocs.io/en/latest/git/commandlinegit.html) 
   2. [Git - The Simple Guide](http://rogerdudler.github.io/git-guide/)
   3. [Setting your commit email](https://help.github.com/articles/setting-your-commit-email-address-in-git/)
   4. [Adding Existing Project](https://help.github.com/articles/adding-an-existing-project-to-github-using-the-command-line/)
   5. [Atlassian Git Tutorial](https://www.atlassian.com/git/tutorials)
   6. [Git-Scm](https://git-scm.com/doc)
3. [Resources](#resource) : :balance_scale: A Market for most popular GUIs for Git and Remote Repositories.
   - [Services](#service)
   - [Software](#software)

<a id="cheatsheet">

## 1. Git Commands Cheatsheet

<a id="config">

[Back To Top](#toc)

#### 0. Configure Git Email/Name: (To start off the whole thing)

Before you do anything, you have to make sure you are safe to interact with github. `git config` does this for you.

```bash
git config --global user.email "you@email.com" #(Your Github Email Here)
git config --global user.name "yourname" #(Your Github Username Here)`
```

Pretty easy right? Now check if everything is alright.

```bash
git config user.name
yourname # should be what you inputed for your name
git config user.email
you@email.com # should be what you inputed for your email
```

If this is good, proceed.

<a id="gitignore">

[Back To Top](#toc)

#### 1. make .gitignore: (What to exclude when submitting)

`.gitignore` is an extremely useful file they don't really teach you about. It basically stops certain files or directories from being uploaded to your github. For instance, uploading node_modules folder will take a long time and be useless! So you would want to exlude things you don't really need. What you want to put up on github is the least amount of code base in order to recreate the same output as your workspace. Here is a sample .gitignore file you can use for almost anything!

```bash
# compiled output
/dist
/tmp
/out-tsc

# dependencies
/node_modules

# IDEs and editors
/.idea
.project
.classpath
.c9/
*.launch
.settings/
*.sublime-workspace

# IDE - VSCode
.vscode/*
!.vscode/settings.json
!.vscode/tasks.json
!.vscode/launch.json
!.vscode/extensions.json

# misc
/.sass-cache
/connect.lock
/coverage
/libpeerconnection.log
npm-debug.log
testem.log
/typings

# e2e
/e2e/*.js
/e2e/*.map

# System Files
.DS_Store
.DS_Store?
._*
.Spotlight-V100
.Trashes
ehthumbs.db
Thumbs.db

# Compiled source #
*.com
*.class
*.dll
*.exe
*.o
*.so

# Packages #
# it's better to unpack these files and commit the raw source
# git has its own built in compression methods
*.7z
*.dmg
*.gz
*.iso
*.jar
*.rar
*.tar
*.zip
```

If you need more, you can simply add to the list, or check out [this page](https://github.com/github/gitignore). This is github's collection of useful `.gitignore` files. Now, lets move on to make something.

<a id="make-new">

[Back To Top](#toc)

#### 2. Make a new Repository: (Start a repo from scratch on your machine)

Let's learn to make a new repo on your computer. First go into your terminal and create a folder.

```bash
# Linux or Mac
md my-folder

# Or windows
mkdir my-folder
```

Then lets start that git

```bash
cd my-folder # move into your folder
git init
```

Now, you will see a .git folder within my-folder. Then just copy your `.gitignore` file into your folder, and write some code. This is now your "local repository" on your machine! (not really, but for our purpose it's fine.)

If you want to create the folder and initialize it at the same time,

```bash
git init my-folder # creates the folder and put .git folder within for you
```

This will do.

If you want to see your local repo uploaded to Github, go to [section 6](#local-to-remote).

<a id="clone">

[Back To Top](#toc)

#### 3. Clone a Repository: (Copy a repo on your machine so you can work on it)

Another thing you may wanna do is get your team's project so you can start on it. This is actually very easy. Since all you're doing is downloading that repository from github, you have to run a one liner.

```bash
git clone https://github.com/your-team/your-teams-project.git
```

You will get that line https address by going to the set repo on github and clicking on green button `clone or download` and copying the address. If you want to make changes and send it to github, go to [section 6](#local-to-remote).

<a id="connect-repos">

[Back To Top](#toc)

#### 4. Remote Add Origin: (Connect Your local and remote repo)

First, you have to make sure your git repo is initialized.

```bash
git init
Reinitialized existing Git repository in C:/Users/you/workspace/my-folder/.git/
```

This will show if you already have a git repo initialized. If you do, now you have to connect your local repo with remote repo.

```bash
git remote add origin https://github.com/yourname/new_repo # <remote = origin>
```

This command will add remote named origin at the address of your github repository. Now your repos are connected!

<a id="pull">

[Back To Top](#toc)

#### 5. Pull from Repository: (Update your local machine to sync with Remote)

**If you have not read [section 4](#connect-repos), please go back and finish section 4 before proceeding.**

Pulling means you are updating the changed files from your github to your computer. It's like checking for updates on your code and if you find an update on github, you get the latest version. Pull is important because before you commit to a branch, you must have same commit history. It's a bit detailed so I won't go into it but make sure before you do **`git push`**, get in the habit of always doing `git pull` first.

```bash
git pull origin master # git pull <remote> <branch>
```

This is all you have to do!

<a id="a-c-p">

[Back To Top](#toc)

#### 6. Add, Commit and Push: (Update the remote repo to sync with machine)

**If you have not read [section 4](#connect-repos), please go back and finish section 4 before proceeding.**

Before I exaplin about pushing, lets go over the data flow in git commands.

![gitflow](./gitflow.png)

Without going into too much detail, you can see two important nodes in the picture : workspace and remote repository. For us, the **workspace** is the folder in your computer. **Remote repository** is thre repository on Github.

We could go into the difference between individual nodes and how they interact, but you need the command to push your project right now, so let's not.

You will get all of your changed files ready to be uploaded to github.

```bash
# this gets all changed files on your computer ready to be sent off to github
git add *
```

Then, you will send them off.

```bash
# send them off with a message for your team with -m tag (the message tag)
git commit -m "this is a commit with message boiz"
```

Now, notice in the above picture how you don't have a direct conenction between workspace and remote repo? so you have to do one more thing to apply the change on github.

```bash
# this puts your code on Github's master branch!
git push origin master

# or, push to existing branch that's not master -> this would be better
git push origin other-branch
```

Now it's up on github for the world to see. Just three lines of command. That easy. Now you are done with the basics of git!

<a id="branch">

[Back To Top](#toc)

#### 7. Branching: (Best way to NOT Screw Up)

One thing I want to tell myself 10 months ago regarding git would be to **branch everytime I make a commit, and delete the branch once merged with master**. This is explained very well in [Git-Scm](https://git-scm.com/doc) website if you want to know why. But the best practice is to create a new branch when something is updated with your code, push it to that branch, merge that branch with master, and delete that branch. Here is how you do it.

```bash
git checkout -b new-branch1 # -b is tag for branching

# You can specify which branch you wanna pull from by tag at the end
git checkout -b new-branch1 old-branch1 # this will clone old-branch1 to new-branch1
```

To switch between different branches, you will do this

```bash
# checkout is the command to switch between branched
git checkout master # now you're at master
git checkout new-branch1 # now you're at new-branch
```

This is probably the simplest thing you can do to save yourself all the trouble with version control. That simple branching for each commit you do. After you merge it with the master with commands on [section 8](#merge), you can delete the branch using this command

```bash
git push -d origin new-branch1 # git push -d <remote_name> <branch_name>
```

<a id="merge">

[Back To Top](#toc)

#### 8. Merge: (Last of Git You need)

If your code is stable and working 100%, then and only then should you merge your branch with master branch. Remember that best practice would be having a functional program on master branch at all times. Some people like to merge on github because it is easy to see the changes. I like to merge on github as well. Also, [GUI softwares](#software) are a really good tool to visualize the commit and merge history. But when the merge conflict is so large, you have to resolve the conflict in you command line, so here are the commands for merging on command line.

```bash
# Make a new branch for your commit remmember?
git checkout -b new-branch2 master # cloning master to new-branch2

# Commit the eddited files
git add <file>
git commit -m "change that"

# Merge in the new-branch2
git checkout master # switch to master
git merge new-branch2 # merge the master and new-branch
git branch -d new-branch2 # delte the new branch after merge!
```

With that, now you know the basics of Git!

<a id="tutorial">

[Back To Top](#toc)

##  2. Git Tutorials

Here are some tutorials I found helpful in learning these commands.

1. [Dont be afraid to commit](http://dont-be-afraid-to-commit.readthedocs.io/en/latest/git/commandlinegit.html) : This page contains fairly thorough examples for every step and commands you will need in order to push a fully functional project on Github. Very detailed and succinct at the same time in terms of explaining what's going on at each step. This would be my recommendation for your first interaction with Git.
2. [Git - The Simple Guide](http://rogerdudler.github.io/git-guide/): You've probably seen this page before. It has visual aids to help you understand the not only the comands but the concepts behind a certain command. For that reason it can be more difficult to understand than it has to be. I recommend reading this page after you finish the first link.
3. [Setting your commit email](https://help.github.com/articles/setting-your-commit-email-address-in-git/): This is official github help page. You have to have this configuration if you want to commit to a remote repository from commandline. If you want more detailed config via commandline, [check out this page](https://git-scm.com/book/en/v2/Customizing-Git-Git-Configuration)
4. [Adding Existing Project](https://help.github.com/articles/adding-an-existing-project-to-github-using-the-command-line/): Step by step guideline of pushing an existing project to github. Easy to follow, especially after the 3rd link.
5. [Atlassian Git Tutorial](https://www.atlassian.com/git/tutorials): Another clean looking tutorial you can follow. Also explains about bitbucket, and has useful commands like `git reset`, or  `git revert` that are otherwise not often seen in tutorials.
6. [Git-Scm](https://git-scm.com/doc): You would know this page if you are working on Windows machine, because you would have to install it from this page. Along with it usually comes git cmd,  git bash, and git GUI. It has too much information for beginners, so read the docs if you want to learn git, not when you need git. [Checkout this page for free book](https://git-scm.com/book/en/v2).



If you've gone through those pages, you will have all info you need to make everyday commits. If you don't have time, definitely go through [link1](http://dont-be-afraid-to-commit.readthedocs.io/en/latest/git/commandlinegit.html), [2](http://rogerdudler.github.io/git-guide/), and [4](https://help.github.com/articles/adding-an-existing-project-to-github-using-the-command-line/). If you wanna learn git commands for the heck of it, the [Atlassian Git Tutorial](https://www.atlassian.com/git/tutorials) is right for you. If you have enough time over the breaks and want to master git, I recommend you checkout [Github Help Page](https://help.github.com/) or read through [Git-Scm](https://git-scm.com/doc).

<a id="resource">

[Back To Top](#toc)

## 3. [Resources](#resource)

Github is amazing and popular, but its not perfect. For me, because of limited availability in Private Repository, I like to use [Gitlab](https://about.gitlab.com/), or [Bitbucket](https://bitbucket.org/). If you use [Sourcetree](https://www.sourcetreeapp.com/) to manage the commit historys you would be familiar with Bitbucket. Gitlab is less intuitive in terms of UI of the web, but it gives a lot more command examples you can use. Below are free services/softwares you can use to make your life easier with git.

<a id="service">

[Back To Top](#toc)

#### Services

- [Github](https://github.com/): Probably your go to choice for git control. Unlimited Private Repository if you get student package. Has static page hosting service.
- [Gitlab](https://about.gitlab.com/): Unlimited Private Repositories + 10GB server hosting for free.
- [Bitbucket](https://bitbucket.org/): Unlimited Private Repositories + Sourcetree Integration.
- [Bitbucket Hosting](https://bitbucket.org/product/enterprise): For hosting a project with Bitbucket.

<a id="software">

[Back To Top](#toc)

#### Softwares

- [Sourcetree](https://www.sourcetreeapp.com/): Simple and Easy GUI for git. Requires Atlassian Account. Has a clean way of showing your commit histories. Goes Best with [Bitbucket](https://bitbucket.org/).
- [Github Desktop](https://desktop.github.com/): Another Great GUI made in Electron Framework. If you have primarily used github website to interact with Git, this will be an easy shift. Goes best with [Github](https://github.com/).
- [Git Kraken](https://www.gitkraken.com/): If you are using this with [Gitlab](https://about.gitlab.com/), It will authenticate you just once and you can easily commit. The speed is what astounds me as it gives around 5MB/s up/download speed when commiting a large project on GUI. 

[Back To Top](#toc)



>  *This page was last updated on : 2017/11/23 _ 02:49*
