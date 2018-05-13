drop table if exists comments;
drop table if exists tag_post;
drop table if exists tag;
drop table if exists post;
drop table if exists users;

create table users(
	u_id numeric primary key,
	username varchar(50),
	password varchar(50),
	picture varchar(50)
);

create table post(
	p_id numeric primary key,
	u_id numeric,
	Title varchar(50),
	storageURL varchar(100),
	constraint fk_users foreign key (u_id) references users(u_id)
);

create table tag(
	t_id numeric primary key,
	tagName varchar(20)
);

create table tag_post(
	p_id numeric,
	t_id numeric,
	constraint tag_post_pk primary key(p_id, t_id),
	constraint post_fk foreign key (p_id) references post(p_id),
	constraint tag_fk foreign key (t_id) references tag(t_id)
);

create table comments(
	c_id numeric primary key,
	u_id numeric,
	p_id numeric,
	text varchar(200),
	constraint fk_users foreign key (u_id) references users(u_id),
	constraint fk_post foreign key (p_id) references post(p_id)
);


-- Inserts, only for testing purposes
insert into users values (1, 'admin', '1234', 'img/user3.jpg');
insert into users values (2, 'testuser1', '1234', 'img/user1.jpg');
insert into users values (3, 'testuser2', '1234', 'img/user2.jpg');

insert into post values (1, 1, 'Look at this awesome cat, tho', 'img/kitten1.jpg');
insert into post values (2, 3, 'This cat is crazy af, lul lul lul lul', 'img/kitten2.jpg');
insert into post values (3, 2, 'He loves me!', 'img/kitten3.jpg');
insert into post values (4, 1, 'This kitty is so majestic', 'img/kitten4.jpg');
insert into post values (5, 1, 'The eyes actually match the bench! Like whaat?', 'img/kitten5.jpg');
insert into post values (6, 3, 'To the food bowl pls, Mr. Taxidriver', 'img/kitten6.jpg');
insert into post values (7, 3, 'Black n´ white kitty', 'img/kitten7.jpg');

insert into tag values (1, 'cat');
insert into tag values (2, 'love');
insert into tag values (3, 'crazy');
insert into tag values (4, 'teeth');
insert into tag values (5, 'majestic');
insert into tag values (6, 'uber');
insert into tag values (7, 'yellow');

insert into tag_post values (1, 1);
insert into tag_post values (1, 3);
insert into tag_post values (2, 1);
insert into tag_post values (2, 4);
insert into tag_post values (2, 3);
insert into tag_post values (3, 1);
insert into tag_post values (3, 2);
insert into tag_post values (4, 1);
insert into tag_post values (4, 5);
insert into tag_post values (5, 7);
insert into tag_post values (5, 1);
insert into tag_post values (6, 1);
insert into tag_post values (6, 6);
insert into tag_post values (6, 2);
insert into tag_post values (7, 1);

insert into comments values (1, 1, 1, 'OMG, so cute');
insert into comments values (2, 1, 3, 'Nah bra, he`s just hungry af');
insert into comments values (3, 2, 1, 'That cat tho!');
insert into comments values (4, 2, 3, 'It`s a lie dude, cats are always mean. He probably wants some food.');
insert into comments values (5, 3, 3, 'He`s only hungry, you dork!');
insert into comments values (6, 3, 3, 'JK, bruh');
