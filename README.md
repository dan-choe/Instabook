# Instabook (Team Project)

![Instabook](https://github.com/dan-choe/Instabook/blob/master/screenshots/Capture4.PNG "Instabook")

[Download Instabook Documentation](https://github.com/dan-choe/Instabook/blob/master/InstabookDocumentation.pdf)

### Team Members:
Dan Choe (devdanchoe@gmail.com or dan.choe@stonybrook.edu)  
Sean Clark (sean.m.clark@stonybrook.edu)  
Nathaniel Clench (nathaniel.clench@stonybrook.edu)  


### Collaboration plan:

Teammate 1 (Dan) will focus on messaging, searching, liking and unliking postings and comments, and group-related privacy issues.
Teammate 2 (Nathaniel) will focus on users, groups, pages, postings, and comments.
Teammate 3 (Sean) will focus on all aspects of targeted advertising and sales.

Additionaly, I, Dan, implemented register, login/out, personal page, and group pages.


### Brief rationale for your E-R model:

We covered the main entities (comments, users, employees, etc) as tables including their respective attributes, and gave them unique ID’s as primary keys. The relationship tables bridge these entities together. User preferences are represented here as a set attribute. In the Friends relationship, User A is friends with User B. Each User will have One page, but can be part of multiple(or no) groups. Similarly, a group has exactly one page. A comment is attached to one post, but a post can have multiple comments. And similarly, a post is attached to one page, but a page can have multiple posts. An employee is part of exactly one company, but a company can have multiple employees.

![ERmodel](https://github.com/dan-choe/Instabook/blob/master/screenshots/erdiagram.PNG "ERmodel")


### Brief rationale for your Relational model:

We made Preferences a separate table where each preference category is a column with either Y or N. Each user will have a row of their preferences. A “Friend Relationship” will be represented by two rows in the Friends table, where A is friends with B, and then B is friends with A. In SendReceive, the primary key is composed of The sender’s user id, the receiver’s user id, and the message id, because one message will only be sent once, but the two users may send multiple messages to each other.

![RelationalModel](https://github.com/dan-choe/Instabook/blob/master/screenshots/relation1.PNG "RelationalModel")
![RelationalModel](https://github.com/dan-choe/Instabook/blob/master/screenshots/relation2.PNG "RelationalModel")

I can't show all the relational model since there are a lot. I put more details in UserGuide file(*.pdf).

## License
Copyright [2017] [Dan Choe](https://github.com/dan-choe)  [Sean Clark](sean.m.clark@stonybrook.edu)   [Nathaniel Clench](nathaniel.clench@stonybrook.edu)


