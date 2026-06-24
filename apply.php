<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Job application page.">
    <meta name="keywords" content="Job">
    <meta name="author" content="Some Company">
    <title>Nameless Company</title>
    <link rel="stylesheet" href="styles/unified.css">
</head>

<body>
    <?php include 'header.inc'; ?>

    <section class="hero" style="height: auto; min-height: 100px;">
        <?php include 'nav.inc'; ?>
    </section>

    <form class="apply-form" method="post" action="http://localhost/group-6-groupprojectwebsite-2/group-6-groupprojectwebsite-2-main/process_eoi.php">
        <h2>PRIUS Online Application Form</h2>
        
        <div class="row-threes">
            <fieldset id="job_reference_number">
                <label for="job_reference_number">Job reference number</label>
                <br>
                <input type="text" name="job_reference_number" id="job_reference_number" required="required" pattern="[0-9]{5}" title="Enter exactly 5 alphanumeric characters">
            </fieldset>
            
            <fieldset id="first_name">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" required="required" pattern="[a-zA-Z]{1,20}" title="Enter at most 20 alpha characters">
            </fieldset>
            
            <fieldset id="last_name">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" required="required" pattern="[a-zA-Z]{1,20}" title="Enter at most 20 alpha characters">
            </fieldset>
        </div>
        
        <div class="row-half">        
            <fieldset id="date_of_birth">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" required="required">
            </fieldset>
            
            <div>
                <label>Gender</label>
                <fieldset id="gender">
                    <p>
                        <input type="radio" id="male" name="gender" value="male" required="required">
                        <label for="male">Male</label> 

                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label> 
                        
                        <input type="radio" id="unknown_gender" name="gender" value="unknown_gender">
                        <label for="unknown_gender">Rather not say</label> 
                    </p>
                </fieldset>
            </div>
        </div>

        <div class="row-half">
            <fieldset id="street_address">
                <p>
                    <label for="street_address">Street Address</label>
                    <br>
                    <input type="text" name="street_address" id="street_address" required="required" pattern="[a-zA-Z]{1,40}" title="Enter at most 40 alpha characters">
                </p>
            </fieldset>
        </div>
        
        <div class="row-threes">
            <fieldset id="suburb_town">
                <p>
                    <label for="suburb_town">Suburb / Town</label> 
                    <br>
                    <input type="text" name="suburb_town" id="suburb_town" required="required" pattern="[a-zA-Z]{1,40}" title="Enter at most 40 alpha characters">
                </p>
            </fieldset>

            <fieldset id="state">
                <p>
                    <label for="state">State</label> 
                    <br>
                    <select name="state" id="state" required="required">
                        <option value="" selected>Please Select</option>
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>	
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>
                    </select>
                </p>
            </fieldset>

            <fieldset id="postcode">
                <p>
                    <label for="postcode">Postcode</label>
                    <br>
                    <input type="text" name="postcode" id="postcode" required="required" pattern="[0-9]{4}" title="Enter exactly 4 digits">
                </p>
            </fieldset>
        </div>
            
        <div class="row-half">
            <fieldset id="email">
                <p>
                    <label for="email">Email</label>
                    <br>
                    <input type="email" name="email" id="email" required="required">
                </p>
            </fieldset>

            <fieldset id="phone_number">
                <p>
                    <label for="phone_number">Phone Number</label>
                    <br>
                    <input type="text" name="phone_number" id="phone_number" required="required" pattern="[0-9]{8,12}" title="Enter a phone number between 8 to 12 digits, without dashes ( - )">
                </p>
            </fieldset>
        </div>

        <div class="row-skill">
            <fieldset id="skill">
                <p><label>Skill list</label></p>
                <p>
                    <input type="checkbox" id="web_development" name="skill[]" value="web_development" checked="checked">
                    <label for="web_development">Web Development</label> 
                </p>
                <p>
                    <input type="checkbox" id="data_analytics" name="skill[]" value="data_analytics">
                    <label for="data_analytics">Data Analytics</label> 
                </p>
                <p>
                    <input type="checkbox" id="accounting" name="skill[]" value="accounting">
                    <label for="accounting">Accounting</label> 
                </p>
                <p>
                    <input type="checkbox" id="project_management" name="skill[]" value="project_management">
                    <label for="project_management">Project Management</label> 
                </p>
                <p>
                    <input type="checkbox" id="other_skills" name="skill[]" value="other_skills">
                    <label for="other_skills">Other skills...</label> 
                </p>
            </fieldset>
                
            <fieldset id="other_skill">
                <label>Other skills</label>
                <br>
                <textarea id="other_skill" name="other_skill" rows="9" placeholder="(OPTIONAL) Other skills goes here..."></textarea>
            </fieldset>
        </div>

        <div class="submissions">
            <p></p>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset Form">
            <p></p>
        </div>
    </form>

    <?php include 'footer.inc'; ?>
</body>
</html>