<?php
//begin the session
session_start();
//DB connector
include 'include/connector.php';
if(isset($_SESSION['accountType'])){
$accType = $_SESSION['accountType'];  
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Onkel Felipe | Menu</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Personal CSS & JavaScript -->
        <link rel="stylesheet" type="text/css" href="css/customcss.css">
        <script src="js/custom.js"></script>
        <script src="js & jquery/jquery.js"></script>
        <script>
            /*This function identifies the user of the page.
            *If he is an unregistered visitor the login & signup options will appear
            but in the case of a user, account & logout options will be shown*/
            $( document ).ready(function() {
                var userview = <?php echo json_encode($_SESSION['firstn']) ?>;

                if(userview != null){
                $("a[href='SignUp.php']").attr('href', 'Account.php');    
                $("a[href='Login.php']").attr('href', 'Logout.php');
                }
            });
        </script> 
      
    </head>
    
    <body>
        <!-- Content container -->
        <div class="container-fluid">
            
        <!-- Navbar -->
        <!-- Reference: W3Schools http://www.w3schools.com/bootstrap/bootstrap_navbar.asp-->
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand" href="Index.php">Onkel Felipe</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="Menu.php">Menu</a></li>
                    <li><a href="AboutUs.php">About Us</a></li>
                    <li><a href="ContactUs.php">Contact Us</a></li>
                    <li><a href="Reservations.php">Reservations</a></li>
                    <?php
                        if(isset($_SESSION['accountType']) && $accType === "Admin"){
                    ?>
                    <li><a href="AdminPage.php">Administrator's Page</a></li>
                    <?php
                        ;}
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="SignUp.php"><span class="glyphicon glyphicon-user"></span><?php if(isset($_SESSION['accountType'])) {echo " Account";} else {echo " SignUp";}?></a></li>
                    <li><a href="Login.php"><span class="glyphicon glyphicon-log-in"></span><?php if(isset($_SESSION['accountType'])) {echo " Logout";} else {echo " Login";}?></a></li>
                </ul>
            </div>
          </div>
        </nav>

            <!--image credit: SnowBrains.com-->     
            <div class="row">     
                <div class="col-md-4"></div>
                <div class="col-md-4 hidden-xs hidden-sm"><a href ="index.php"><img class="img-responsive" src="images/4pints.png"></a></div>
                <div class="col-md-4"></div>
            </div> 
            <!-- end of navbar -->

            <!-- Menu -->	
                <div class="col-sm-2"></div>
                <div class="col-sm-8 bhoechie-tab-container">
                    <!-- menu header -->
                    <div class="col-sm-3 bhoechie-tab-menu">
                        <div class="list-group">
                            <a href="#" class="list-group-item active text-center">Beer</a>
                            <a href="#" class="list-group-item text-center">Main Dishes</a>
                            <a href="#" class="list-group-item text-center">Cheese</a>
                            <a href="#" class="list-group-item text-center">Deli</a>
                            <a href="#" class="list-group-item text-center">Salads</a> 
                        </div>
                    </div>
                    <!-- menu body -->
                    <div class="col-sm-9 bhoechie-tab">
                        <!-- beer -->
                        <div class="bhoechie-tab-content active" style="font-family: Helvetica Neue; font-size: 120%;">
                            <center>
                            <h2><b>Our Beers</b></h2> 
                            <hr>
                            <ol>
                            <h4><b>"Beers, ales , stouts and everything you have ever heard.." Felipe</b></h4> 
                            <h6><i>*Our bar staff will be there to help you find the perfect beer mug.</i></h6><br> 
                            <li><p>Guinness (4.1% alcohol) </p></li>
                            <li><p>Blue Moon (5% alcohol)</p></li>
                            <li><p>Samuel Adams Boston Lager(4.75% alcohol)</p></li>
                            <li><p>Heineken International(5% alcohol))</p></li>
                            <li><p>Corona(5% alcohol)</p></li>
                            <li><p>Stella Artois(5% alcohol)</p></li>
                            <li><p>Dos Equis(2.5% alcohol)</p></li>
                            <li><p>Budweiser(4% alcohol)</p></li>
                            <li><p>Strongbow(12% alcohol)</p></li>
                            <li><p>Murphy's(5% alcohol)</p></li>
                            <li><p>Fat Tire(5.2% alcohol)</p></li>
                            <li><p>Sierra Nevada(8% alcohol)</p></li>
                            </ol>
                            </center>
                        </div>

                        <!-- main dishes -->
                        <div class="bhoechie-tab-content" style="font-family: Helvetica Neue; font-size: 120%;">
                            <center>
                                <h2><b>Our Main Dishes</b></h2>
                                <hr>
                                <ol>
                                <h4><b>"Robust meats are best enjoyed with extreme garlic mashed potatoes!!.." Felipe</b></h4> 
                                <h6><i>*Our bar staff will be there to help you find the perfect match for your plate.</i></h6><br>
                                <li><p>Filet Mignon (expertly grill tenderloin for the perfect bite every time) </p></li>
                                <li><p>Beef Ancho (special cooked rib eye over direct heat to deliver a unique texture)</p></li>
                                <li><p>Crispy Pork Ears (with thyme honey sauce and pamesan flakes)</p></li>
                                <li><p>Costela Beef Ribs (seasoned crusted and grilled for several hours)</p></li>
                                <li><p>Ribeye Steak Cheeseburger (with fried egg, crisp onions and sautéed wild mushrooms)</p></li>
                                <li><p>Maple Glazed Pork Ribs (served with grilled Brussels sprouts and cashew butter)</p></li>
                                <li><p>Royal Barbecued Pork Loin (smoky, sweet and spicy with silky meat inside)</p></li>
                                <li><p>Glazed Ham (with quality bitter marmalade, golden rum and malt vinegar)</p></li>
                                <li><p>Slow Roasted Pork Shoulder (with onion gravy and lime coated asparagus)</p></li>
                                <li><p>Frango Chicken (beer and brandy marinaded and wraped in savory bacon)</p></li>
                                <li><p>Pecan Crusted Chicken Wings (paired with caramelized onions and honey mustard sauce)</p></li>
                                <li><p>Roast Duck (crispy and delicious, served with orange and ginger sauce</p></li>
                                <li><p>Cordeiro Lamb (a tender leg of lamb with a pleasant taste twist)</p></li>
                                <li><p>Smoked Salmon (with mediterranean basil and sweet chili sauce)</p></li>
                                <li><p>Black Olive Tuna (covered in oregano and feta sauce)</p></li>
                                <li><p>Apple Mackerel (with fennel and lime yoghurt sauce)</p></li>
                                <li><p>Garlic Lobster (sautéed in garlic butter with onions and served with mango sause)</p></li>
                                <li><p>Shrimp Volcano Mix (coated in extremly hot habanero sauce)</p></li>
                                <li><p>Ribeye Steak Cheeseburger (with fried egg, crisp onions and sautéed wild mushrooms)</p></li>
                                <li><p>Black Truffle Lobster Burger (gorgonzola, honey balsamic sauce and crispy onions)</p></li>
                                </ol>
                            </center>
                        </div>
                        <!-- cheese -->
                        <div class="bhoechie-tab-content" style="font-family: Helvetica Neue; font-size: 120%;">
                            <center>
                                <h2><b>Our Variety of Cheese</b></h2>
                                <hr>
                                <ol>
                                <li><p>Abbot's Gold (English Caramelised Onion Cheddar)</p></li>
                                <li><p>Adelost (Swedish blue cheese)</p></li>
                                <li><p>Affineur Walo Rotwein Sennechäs (Swiss cheese matured in red wine)</p></li>
                                <li><p>Aged British Cheddar</p></li>
                                <li><p>Aged Gouda (Dutch cheese)</p></li>
                                <li><p>Anejo Enchilado (aged Mexican cheese rolled in paprika)</p></li>
                                <li><p>Barrel Aged Feta (classic Greek feta)</p></li>
                                <li><p>Basajo (creamy Italian blue cheese)</p></li>
                                <li><p>Bawarii Bergkäse (hard German artisan cheese)</p></li>
                                <li><p>Black Pearl (hard Australian artisan cheese)</p></li>
                                <li><p>Brie (soft-rippened French cheese)</p></li>
                                <li><p>Cahill's Irish Porter Cheddar (mosaic pattern)</p></li>
                                <li><p>Cambozola (triple cream, German blue cheese)</p></li>
                                <li><p>Camembert (French soft)</p></li>
                                <li><p>Danablu (Danish Blue)</p></li>
                                <li><p>Detroit Street Brick (peppery, hard, US)</p></li>
                                <li><p>Dinarski Iz Mosta (hard and grassy, Croatia)</p></li>
                                <li><p>Dry Jack (brittle and nutty, US)</p></li>
                                <li><p>Ellington (aged and creamy, US)</p></li>
                                <li><p>Emmental (Switzerland)</p></li>
                                <li><p>Fiery Rebel Cheese (peppery flavoured speciality, Austria)</p></li>
                                <li><p>Forme (soft Italian, aged with dried mint leaves)</p></li>
                                <li><p>Fragolone (strawberry-shaped Italian, aged with white wine)</p></li>
                                <li><p>Gorgonzola (Italian, one of the world's oldest blue-veined cheeses)</p></li>
                                <li><p>Habanero Cheddar (savoury, spicy and tangy, US)</p></li>
                                <li><p>Halloumi (Cypriot, chewy, creamy and firm)</p></li>
                                <li><p>Herbes de Provence Chèvre (semi-soft, coated in herbes, US)</p></li>
                                <li><p>Huntsman (Stilton between layers of satiny Double Gloucester, UK)</p></li>
                                <li><p>Isabirra (Canadian brined in salt, soaked in dark craft beer and coated in barley malt)</p></li>
                                <li><p>Jarlsberg (Norwegian mild, semi-soft)</p></li>
                                <li><p>Juustoleipä (Finnish semi-hard, salty and sweet)</p></li>
                                <li><p>Käse Mit Schweizer Trüffeln (aged luxurious cheese with truffles)</p></li>
                                <li><p>Kefir Tomato-Garlic (creamy, dense and firm, US)</p></li>
                                <li><p>La Sauvagine Réserve (triple crème Canadian, smooth and unctuous texture)</p></li>
                                <li><p>Mozzarella (Italian traditional specialty)</p></li>
                                <li><p>Myzithra (traditional unpasteurised Greek cheese)</p></li>
                                <li><p>Oasis (Australian coated with chives, garlic and sun-roasted, dried capsicum)</p></li>
                                <li><p>Parmesan (famous Italian cheese)</p></li>
                                <li><p>Pecorino Barba Del Passatore (Italian, covered with corn silk, agedin virgin fir crates)</p></li>
                                <li><p>Pecorino al Tartufo (Italian, encrusted with small specks of white and black truffle)</p></li>
                                <li><p>Provolone Piccante (Italian, semi-hard)</p></li>
                                <li><p>Purple's a Must (Italian, aged, and soaked in Barolo wine)</p></li>
                                <li><p>Red Windsor (pinkish white marbled English cheddar, laced with Bordeaux wine)</p></li>
                                <li><p>Red Leicester (traditional hard English cheese)</p></li>
                                <li><p>Roquefort (popular French, a favorite of Emperor Charlemagne)</p></li>
                                <li><p>Scotch Bonnet Cheddar (withScotch Bonnet chilli peppers, 50 times hotter than a jalapeno, UK)</p></li>
                                <li><p>Smoked Gouda (buttery and crumbly, Holland )</p></li>
                                <li><p>Stilton (blue-veined, one of the best British cheeses</p></li>
                                <li><p>Van Gogh Edam (sweet, creamy flavour with a pleasant salty taste, US)</p></li>
                                <li><p>Walnut Cheddar (awards winning Irish cheese)</p></li>
                                <li><p>White Stilton with Mango & Ginger (creamy and delicious British cheese)</p></li>
                                <li><p>Yorkshire Blue (traditional, vegetarian, blue cheese, UK)</p></li>
                                <li><p>Za'atar Burrata (Italian, filled with labne, mascarpone, and a Middle Eastern herb mixture)</p></li>
                                </ol>
                            </center>
                        </div>
                        <!-- deli -->
                        <div class="bhoechie-tab-content" style="font-family: Helvetica Neue; font-size: 120%;">
                            <center>
                                <h2><b>Our Deli</b></h2>
                                <hr>
                                <ol>
                                <li><p>Ahle Wurst (German hard pork sausage)</p></li>
                                <li><p>Andouillette (French coarse-grained sausage with pork, intestines, pepper, wine, onions and seasoning)</p></li>
                                <li><p>Beef pastrami (coated corned beef with pepper and spices and then smoked)</p></li>
                                <li><p>Bierwurst (Bavarian smoked sausage, with a garlicky flavor and dark red color)</p></li>
                                <li><p>Black pudding (blood sausage made from pork fat, blood and a relatively high proportion of oatmeal)</p></li>
                                <li><p>Bregenwurst (specialty sausage of Lower Saxony, made of pork, pork belly, and pig brain)</p></li>
                                <li><p>Cabanossi (type of dry sausage, similar to a mild salami)</p></li>
                                <li><p>Chicken breast supreme (whole chicken breast fillets that have been pressed and steamed)</p></li>
                                <li><p>Chicken roll (mixture of chicken meat and seasonings)</p></li>
                                <li><p>Chorizo (cured Spanish sausage made from pork, garlic, black pepper and smoked paprika)</p></li>
                                <li><p>Choriatiko Sausage (Greek, made from pork and spicy)</p></li>
                                <li><p>Falukorv (Swedish sausage, smoked pork and beef with potato starch flour, onion, salt and mild spices)</p></li>
                                <li><p>Frankfurter Rindswurst (Germnan beef sausage)</p></li>
                                <li><p>Gelbwurst (Bavarian yellow sausage, made from pork, veal and mixed spices)</p></li>
                                <li><p>Ham off the bone (cured pork leg)</p></li>
                                <li><p>Knipp (sausage made from oat groats and pork)</p></li>
                                <li><p>Liverwurst (German liver sausage)</p></li>
                                <li><p>Medisterpølse (Scandinavian specialty, a thick, spicy sausage made of minced pork)</p></li>
                                <li><p>Moronga (Cuban blood sausage)</p></li>
                                <li><p>Mortadella (a type of cooked salami)</p></li>
                                <li><p>Nduja (a particularly spicy, spreadable pork salumi from Italy)</p></li>
                                <li><p>Pancetta (The Italian version of bacon, pancetta comes from pork belly)</p></li>
                                <li><p>Pepperoni (spicy cured sausage)</p></li>
                                <li><p>Pleșcoi (Romanian sausage made from mutton spiced with chili peppers and garlic)</p></li>
                                <li><p>Prosciutto (similar to pancetta, but contains less fat as it comes from the pork leg)</p></li>
                                <li><p>Rød pølse (brightly red, boiled pork sausage, Denmark)</p></li>
                                <li><p>Roast beef (a roasting cut of beef, usually silverside)</p></li>
                                <li><p>Ryynimakkara (Finnish groat sausage)</p></li>
                                <li><p>Salami (a type of cured sausage)</p></li>
                                <li><p>Sujuk (a dry, spicy Armenian sausage)</p></li>
                                <li><p>Weisswurst (Bavarian white sausage, made from minced veal and pork back bacon)</p></li>
                                <li><p>White pudding (Irish sausage, made of pork meat, fat, suet, bread and oatmeal)</p></li>
                                </ol>
                            </center>
                        </div>
                        <!-- salads -->
                        <div class="bhoechie-tab-content" style="font-family: Helvetica Neue; font-size: 120%;">
                            <center>
                                <h2><b>Our Salads</b></h2>
                                <hr>
                                <ol>
                                <li><p>Seared Tuna Salad (cabbage, kale, roasted almonds and pomegranate vinaigrette)</p></li>
                                <li><p>Candied bacon Salad (lettuce, apple, figs, walnuts and extra virgin olive oil)</p></li>
                                <li><p>Baked Tomatoes Salad (kalamata olives, feta, fresh basil and extra virgin olive oil)</p></li>
                                <li><p>Beetroot Special Salad (carrot, orange, sesame seeds, coriander and honey balsamic)</p></li>
                                <li><p>Red Chilli Egg Salad (round lettuce, dijon mustard, rapeseed oil and buttermilk)</p></li>
                                <li><p>Scandinavian Salad (beetroot, fennel, baby radishes, pickled walnuts and sour cream)</p></li>
                                <li><p>Winter Salad (quinoa, mixed-colour kale, hazelnuts, broccoli and tahini)</p></li>
                                <li><p>Chicken Caesar (lettuce, cauliflower, parmesan, anchovy, wholemeal bread and special sauce)</p></li>
                                <li><p>Quinoa Candied Chicken Salad (baby spinach, red onions, yellow chilli and mango sauce)</p></li>
                                <li><p>Crispy Beef Salad (cucumber, onions, wholemeal croutons, baby carrots and runny honey)</p></li>
                                </ol>
                            </center>
                        </div>
                    </div>
                </div>
                        <div class="col-sm-2"></div>
                </div>

    
    </body>
</html>