UPDATE national_events SET title = REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]')

select TABLE_NAME from information_schema.columns
where table_schema = 'nriscom_nris'
and column_name like 'title'
order by table_name,ordinal_position

UPDATE national_events
SET title = REPLACE(title, '@', '-')
WHERE ID <= 4

UPDATE admins SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE auto_colors SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE auto_makes SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE baby_sitting_categories SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE batches_categories SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE batches_category SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE blogs_categoires SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE carpool SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE carpool_comment SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE casinos SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE categories SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE cities SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE city_movies SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE countries SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE desi_pages_cat SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE education_teaching_categories SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE electronic_categories SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE events_category SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE forums_categoires SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE forums_parent_categoires SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE garagesale_categoires SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE groceries SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE job_categories SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE mypartner_categories SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_carpool SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_casinos SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_city_movies SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_groceries SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_participating_businesses SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_restaurants SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_temples SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE new_theaters SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE participating_businesses SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE realestate_categoires SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE restaurants SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE room_mate_categoires SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE sliders SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE sports SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE states SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE temples SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE theaters SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
UPDATE videos_languages SET name=REGEXP_REPLACE(name, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');



update adduniversity_topic set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update auto_classifieds set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update batches set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update blogs set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update desi_pages set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update events set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update forums_thread set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update national_batches set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update national_events set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_auto_classifieds set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_blogs set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_events set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_forums_thread set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_national_batches set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_national_events set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_news_videos set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_nris_talk set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_baby_sitting set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_education set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_electronics set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_garagesale set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_job set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_mypartner set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_other set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_real_estate set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_roommates set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_post_free_stuff set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_university_student_talk set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update new_videos set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update news_videos set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update nris_talk set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_baby_sitting set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_education set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_electronics set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_garagesale set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_job set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_mypartner set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_other set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_real_estate set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_roommates set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update post_free_stuff set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update university_student_talk set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');
update videos set title =REGEXP_REPLACE(title, '[áéíóúñÁÉÍÓÚÑ]', '[aeiounAEIOUN]');


ALTER TABLE `news_videos` ADD `meta_title` VARCHAR(250) NOT NULL AFTER `content`, ADD `meta_description` VARCHAR(250) NOT NULL AFTER `meta_title`, ADD `meta_keywords` VARCHAR(250) NOT NULL AFTER `meta_description`;

         $news->meta_title = $request->meta_title;
            $news->meta_description = $request->meta_description;
            $news->meta_keywords = $request->meta_keywords;


                          <?php $metainfo = $news ;
              $meta_page_name = 'News Videos';
              ?> @include('layouts.admin_meta')




52) User was given but not displaying in the list[re update the values ]->it working 
45) https://usa.nris.com/profile/my_ads->fixed
46) total nris user profiles are not working showing error please check ->working fine 
42) https://nebraska.nris.com/profile/my_ads not able to post in free stuff plz check ->working fine 
41) https://nris.com/admin/educationteaching-classified two eye icons are displaying -> is valid only 
40) All movie pages are showing error ->working fine 
32)  https://ohio.nris.com/national-autos/create_free_ad not able to post ad in autos its showing error after saving[from next time plz add screenshot] => able to save https://nris.com/admin/auto-classified/886
31) https://minnesota.nris.com/profile/my_ads while posting add its showing error
29) https://nris.com/admin/nritalk keep eye icon in nris talk   add text boxes for meta title, description and  keywords ->done
WWWW) Button not working



https://usa.nris.com/national-events/bollywood-nights-atx-biggest-bollywood-dance-party-dj-nish-dj-anupi-2133
https://usa.nris.com/national-events/bollywood-nights-atx-biggest-bollywood-dance-party-dj-nish-dj-anupi-adsfred


ALTER TABLE `national_events` ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;

 alter table national_events  add UNIQUE(url_slug);
 alter table national_events  add UNIQUE(title);


SELECT id, title, COUNT(title) FROM national_events GROUP BY title HAVING COUNT(title) > 1

UPDATE national_events AS c1
JOIN (
  SELECT title, COUNT(*) AS count
  FROM national_events
  GROUP BY title
  HAVING COUNT(*) > 1
) AS c2 ON c1.title = c2.title
SET c1.title = CONCAT(c1.title, ' (', c2.count, ')')

ALTER TABLE `national_events` CHANGE `title` `title` VARCHAR(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `national_events` CHANGE `title` `title` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `national_events` CHANGE `title` `title` VARCHAR(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;



    $a =  NationalEvent::all();
           echo "<pre>";
        foreach($a as $k=>$v){
        $event = NationalEvent::findOrNew($v->id);
        $event->url_slug = $this->clean($v->title);
        $event->save();
     
        }
 
        // print_r($a);
        exit;


ALTER TABLE adduniversity_topic  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE auto_classifieds  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE batches  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE blogs  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE desi_pages  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE events  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE forums_thread  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE national_batches  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_auto_classifieds  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_blogs  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_events  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_forums_thread  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_national_batches  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_national_events  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_news_videos  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_nris_talk  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_baby_sitting  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_education  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_electronics  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_garagesale  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_job  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_mypartner  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_other  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_real_estate  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_roommates  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_post_free_stuff  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_university_student_talk  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE new_videos  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE news_videos  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE nris_talk  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_baby_sitting  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_education  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_electronics  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_garagesale  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_job  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_mypartner  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_other  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_real_estate  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_roommates  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE post_free_stuff  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE university_student_talk  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;
ALTER TABLE videos  ADD `url_slug` VARCHAR(250) NOT NULL AFTER `title`;


20-04-23
ALTER TABLE `countries` ADD `meta_title` VARCHAR(250) NOT NULL AFTER `image`, ADD `meta_description` VARCHAR(250) NOT NULL AFTER `meta_title`, ADD `meta_keywords` VARCHAR(250) NOT NULL AFTER `meta_description`

ALTER TABLE `states` ADD `meta_title` VARCHAR(250) NOT NULL AFTER `logo`, ADD `meta_description` VARCHAR(250) NOT NULL AFTER `meta_title`, ADD `meta_keywords` VARCHAR(250) NOT NULL AFTER `meta_description`

21-04-2023
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$title = 'My Title';

// Check if a record with the same title exists
$count = DB::table('table_name')->where('title', $title)->count();

if ($count > 0) {
    // If a record with the same title exists, append a count to the title
    $title = $title . '-' . ($count + 1);
}

// Insert the new record with the modified title
DB::table('table_name')->insert([
    'title' => $title,
    // add other fields as necessary
]);


 $ABC = DB::select("UPDATE $v AS c1 JOIN (
   SELECT title, COUNT(*) AS count
   FROM $v
   GROUP BY title
   HAVING COUNT(*) > 1
 ) AS c2 ON c1.title = c2.title
 SET c1.title = CONCAT(c1.title, ' (', c2.count, ')') ") ;

ALTER TABLE `auto_makes` CHANGE `name` `name` VARCHAR(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
ALTER TABLE `carpool` CHANGE `name` `name` VARCHAR(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
 alter table carpool  add UNIQUE(name);

-- remove duplciate 
 UPDATE carpool
JOIN (
    SELECT name, COUNT(*) as cnt
    FROM carpool
    GROUP BY name
    HAVING COUNT(*) > 1
) AS t ON carpool.name = t.name
SET carpool.name = CONCAT(carpool.name, '-', t.cnt);


check diplicate name 
SELECT id, name, COUNT(name) FROM city_movies GROUP BY name HAVING COUNT(name) > 1

27-04-2023
ALTER TABLE `pubs` ADD `url_slug` VARCHAR(300) NOT NULL AFTER `pub_name`;

--  UPDATE pubs
-- JOIN (
--     SELECT pub_name, COUNT(*) as cnt
--     FROM pubs
--     GROUP BY pub_name
--     HAVING COUNT(*) > 1
-- ) AS t ON pubs.pub_name = t.pub_name
-- SET pubs.pub_name = CONCAT(pubs.pub_name, '-', t.cnt);


UPDATE pubs u1 JOIN ( SELECT pub_name, COUNT(*) AS cnt, GROUP_CONCAT(id ORDER BY id) AS ids FROM pubs GROUP BY pub_name
 HAVING COUNT(*) > 1 ) AS u2 ON u1.pub_name = u2.pub_name SET u1.pub_name = CONCAT(u1.pub_name, '-', FIND_IN_SET(u1.id, u2.ids))

DROP TABLE `news_videos`, `new_advertise_with_us`, `new_auto_classifieds`, `new_blogs`, `new_blogs_like`,
 `new_carpool`, `new_casinos`, `new_city_movies`, `new_events`, `new_forums_thread`, `new_groceries`, `new_home_advertisements`,
  `new_movies_external_rating`, `new_national_batches`, `new_national_events`, `new_news_videos`, `new_nris_card`, 
  `new_nris_like`, `new_nris_talk`, `new_participating_businesses`, `new_post_free_baby_sitting`, `new_post_free_education`, 
  `new_post_free_electronics`, `new_post_free_garagesale`, `new_post_free_job`, `new_post_free_mypartner`, `new_post_free_other`,
   `new_post_free_real_estate`, `new_post_free_roommates`, `new_post_free_stuff`, `new_pubs`, `new_restaurants`, 
   `new_student_talk`, `new_temples`, `new_theaters`, `new_university_student_talk`, `new_users`, `new_videos`, 
   `new_videos_like`;

ALTER TABLE `admins` CHANGE `created_by` `created_by` INT(11) NOT NULL DEFAULT '0';

28-04-2023

USE your_database_name;

DELIMITER $$

CREATE PROCEDURE add_created_by_column()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE tbl_name VARCHAR(64);
    DECLARE cur CURSOR FOR SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE();
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO tbl_name;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET @sql = CONCAT('ALTER TABLE ', tbl_name, ' ADD COLUMN created_by VARCHAR(50) NULL');
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

    END LOOP;

    CLOSE cur;
END$$

DELIMITER ;

CALL add_created_by_column();