# Dropsolid Cache exercise

## Install

A basic Drupal installtion can be found in the repo.
- Database: dropsolid_cache_exercise.sql.gz
- Folder structure: dropsolid_cache_exercise.zip

### Installation Steps
- Export the zip to your local projects folder
- In the modules folder, download the dropsolid_cache_exercise module (git clone git@gitlab.com:dropsolid-drupal8/dropsolid-acceptance/dropsolid_cache_exercise.git)
- Create a database named 'dropsolid_cache_exercise' with username and password 'cache_exercise'
- Add a new entry in your mamp / local setup.
- Go to your new site :) (and maybe do a cache rebuild, drush cr)

## Start!
After you installed the site go to the homepage with this parameter '?drop=not-so-solid' (-> example: 'http://exercise.local/?drop=solid') after an cache clear it should look like this: https://imgur.com/a/Gpzli
You'll notice that when you change the parameter or any node title that the blocks don't change with them. Fixit.

## Exercise 1 (InfoBlock.php )
 - This block shows 2 hard coded nodes in one block, can be viewed on the frontpage . When updating the title of the 2 nodes, this block should also contain the new titles.

## Exercise 2 (ShowQueryArgBlock.php)
- On the homepage there is a block that prints out the query parameter ( ?drop=[value] ).
- When you go to the same url with a different parameter ( ?drop=[value] ) that block has to print out the new parameter.

## Exercise 3 (LatestArticles.php)
- On the homepage you have an overview of x nodes, when creating/updating/deleting a (new) node, this overview should contain the (new) node.

## Exercise 4 (ShowQueryArgBlockTwig.php)
- This is the same block as the Show query arg block block and can be found on the homepage, but here it gets loaded through a twig file.
- When you change the query parameter, this doesn't get updated.

# Run the site with Docker

If you have Docker installed in your machine you just need to run:

```
docker-compose up -d drupal phpmyadmin
composer install -d docroot/ --ignore-platform-reqs
mkdir docroot/sites/default/files
chmod -R a+w docroot/sites/default/files
```

Note: The MySQL container can take some minutes to import the database.

To get the site running with phpMyAdmin.

- Drupal: http://localhost:8080/
- phpMyAdmin: http://localhost:8081/
