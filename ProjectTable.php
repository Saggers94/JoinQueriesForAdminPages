<?php

//adding up the namespace
namespace App\Model;


//declaring the project table which extends base modelfinalclass
class ProjectTable extends ModelFinalClass
{
    //declaring the common variable from the query
    protected $table = 'project';
    protected $key = 'project_id';

    //overriding the 'all' function of the basemodel
    public function all()
    {

        //declare the query text, prpare the query, execute it and return the result

        $query = "SELECT {$this->table}.*, category.category_name from {$this->table}
                  LEFT JOIN category ON project.category_id = category.category_id";

        $stmt = self::$dbh->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //get the project by name from the project table
    public function getProjectByName($project_name){

        //declare the query text, prpare the query, adding params execute it and return the result
        $query = "SELECT category.category_name, {$this->table}.* FROM {$this->table} INNER JOIN category USING (category_id) WHERE project_name = :project_name";

        $stmt = self::$dbh->prepare($query);

        $params = array(
            ':project_name' => $project_name
        );

        $stmt->execute($params);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    //adding project in the database
    public function addProject($project){

        //declare the query text, prpare the query, adding params execute it and return the result
        $query = "INSERT INTO {$this->table} (
                                            project_name,
                                            category_id,
                                            project_simple_description,
                                            project_detailed_description,
                                            project_technology,
                                            project_developer_full_name,
                                            image,
                                            allow_comments,
                                            project_cost,
                                            project_start_date,
                                            project_end_date,
                                            developing_status,
                                            project_displayed_on_site
                                            ) VALUES 
                                            (
                                            :project_name,
                                            :category_id,
                                            :project_simple_description,
                                            :project_detailed_description,
                                            :project_technology,
                                            :project_developer_full_name,
                                            :image,
                                            :allow_comments,
                                            :project_cost,
                                            :project_start_date,
                                            :project_end_date,
                                            :developing_status,
                                            :project_displayed_on_site
                                            )";

        $stmt = self::$dbh->prepare($query);

        $params = array(
            ':project_name' => $project['project_name'],
            ':category_id' => $project['project_category_name'],
            ':project_simple_description' => $project['project_simple_description'],
            ':project_detailed_description' => $project['project__detailed_description'],
            ':project_technology' => $project['project_technology'],
            ':project_developer_full_name' => $project['project_developer_full_name'],
            ':image' => $project['image'],
            ':allow_comments' => intval($project['allow_comments']),
            ':project_cost' => $project['project_cost'],
            ':project_start_date' => $project['project_start_date'],
            ':project_end_date' => $project['project_end_date'],
            ':developing_status' => $project['developing_status'],
            ':project_displayed_on_site' => $project['displayedradio']
        );

        $stmt->execute($params);

        return self::$dbh->lastInsertId();                                    
    }


        //updating the project
        public function updateProject($project, $id){
        
        //declare the query text, prpare the query, adding params execute it and return the result
        $query = "UPDATE {$this->table} SET
                    project_name = :project_name,
                    category_id = :category_id,
                    project_simple_description = :project_simple_description,
                    project_detailed_description = :project_detailed_description,
                    project_technology = :project_technology,
                    project_developer_full_name = :project_developer_full_name,
                    image = :image,
                    allow_comments = :allow_comments,
                    project_cost = :project_cost,
                    project_start_date = :project_start_date,
                    project_end_date = :project_end_date,
                    developing_status = :developing_status,
                    project_displayed_on_site = :project_displayed_on_site WHERE project_id = :id";

        $stmt = self::$dbh->prepare($query);

        if(empty($project['allow_comments'])){
            $project['allow_comments'] = 0;
        }

        $params = array(
            ':id' => $id,
            ':project_name' => $project['project_name'],
            ':category_id' => $project['project_category_name'],
            ':project_simple_description' => $project['project_simple_description'],
            ':project_detailed_description' => $project['project__detailed_description'],
            ':project_technology' => $project['project_technology'],
            ':project_developer_full_name' => $project['project_developer_full_name'],
            ':image' => $project['image'],
            ':allow_comments' => intval($project['allow_comments']),
            ':project_cost' => $project['project_cost'],
            ':project_start_date' => $project['project_start_date'],
            ':project_end_date' => $project['project_end_date'],
            ':developing_status' => $project['developing_status'],
            ':project_displayed_on_site' => $project['displayedradio']
        );

        $stmt->execute($params);

        return $stmt->rowCount();                                    
    }

    //delete the project by comparing the project_id
    public function deleteProject($project_id){

        //declare the query text, prpare the query, adding params execute it and return the result

        $query = "delete from {$this->table} where project_id = :project_id";

        $stmt = self::$dbh->prepare($query);

        $params = array(
            ':project_id' => $project_id
        );

        $stmt->execute($params);

        return $stmt->rowCount();
    }

        //etraa query
        //Collecting data for dashboard

        // select avg(project_cost) from project;
         
        // select count(project_id) from project where developing_status = 'complete';

        // select project_name from project where project_cost in(select min(project_cost) from project);
        
        //select project_name from project where project_cost in(select max(project_cost) from project);


}