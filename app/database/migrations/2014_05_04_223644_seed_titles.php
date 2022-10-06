<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTitles extends Migration {

    /**
     * These are sample it titles to start with
     * (we can pull other titles from Monster)
     * @var array
     */
    public $itTitles = array(
        "Application Developer",
        "Application Support Analyst",
        "Applications Engineer",
        "Associate Developer",
        "Chief Technology Officer",
        "Chief Information Officer",
        "Computer and Information Systems Manager",
        "Computer Systems Manager",
        "Customer Support Administrator",
        "Customer Support Specialist",
        "Data Center Support Specialist",
        "Data Quality Manager",
        "Database Administrator",
        "Desktop Support Manager",
        "Desktop Support Specialist",
        "Developer",
        "Director of Technology",
        "Front End Developer",
        "Help Desk Specialist",
        "Help Desk Technician",
        "Information Technology Coordinator",
        "Information Technology Director",
        "Information Technology Manager",
        "IT Support Manager",
        "IT Support Specialist",
        "IT Systems Administrator",
        "Java Developer",
        "Junior Software Engineer",
        "Management Information Systems Director",
        ".NET Developer",
        "Network Architect",
        "Network Engineer",
        "Network Systems Administrator",
        "Programmer",
        "Programmer Analyst",
        "Security Specialist",
        "Senior Applications Engineer",
        "Senior Database Administrator",
        "Senior Network Architect",
        "Senior Network Engineer",
        "Senior Network System Administrator",
        "Senior Programmer",
        "Senior Programmer Analyst",
        "Senior Security Specialist",
        "Senior Software Engineer",
        "Senior Support Specialist",
        "Senior System Administrator",
        "Senior System Analyst",
        "Senior System Architect",
        "Senior System Designer",
        "Senior Systems Analyst",
        "Senior Systems Software Engineer",
        "Senior Web Administrator",
        "Senior Web Developer",
        "Software Architech",
        "Software Engineer",
        "Software Quality Assurance Analyst",
        "Support Specialist",
        "Systems Administrator",
        "Systems Analyst",
        "System Architect",
        "Systems Designer",
        "Systems Software Engineer",
        "Technical Operations Officer",
        "Technical Support Engineer",
        "Technical Support Specialist",
        "Technical Specialist",
        "Telecommunications Specialist",
        "Web Administrator",
        "Web Developer",
        "Webmaster"
    );

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        foreach ($this->itTitles as $title){
            Title::create(array('name'=>$title));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->itTitles as $title){
            $row = Title::where('name','=',$title);
            $row->delete();
        }
    }


}
