Redovisning kmom04
------

####Vad tycker du om formulärhantering som visas i kursmomentet?
Det har sin charm men det var svårt att implementera och först och främst förvirrande. Men antar att det handlar
om att man inte är van. Tog lite tid att figurera ut hur CFormUser och CFormComment skulle se ut och hur man skulle
implementera alla funktioner så att de skulle hänga samman med dem. Fiffigt att metoden save i CDatabaseModel kan
definera ifall ett meddelande/användare ska uppdateras eller skapas beroende på om det finns ett id eller inte. Så
det finns definitivt mycket som är bra och smidigt med detta sätt men det var mycket svårt att implementera.

####Vad tycker du om databashanteringen som visas, föredrar du kanske traditionell SQL?
Det är ju så klart mycket lättare med traditionell SQL eller PDO men den här databashanteringen kan vara bättre
vid större komplicerade projekt med mycket databaser och det kan vara skönt att inte skriva någon SQL utan bara
använda sig av funktioner. Men det blir väldigt rörigt för mig.

####Gjorde du några vägval, eller extra saker, när du utvecklade basklassen för modeller?
Först och främst skapade jag tomma klasser User och Comment som ärver klassen CDatabaseModel och på så sätt få tillgång
till dess metoder. Sen skapade jag CFormComment och CFormUser baserade på CForm. Sedan hämtades allt innehåll i formen
genom metoden getHTML i cform. 

####Beskriv vilka vägval du gjorde och hur du valde att implementera kommentarer i databasen.
Använde mig av samma principer som när jag skapade kommentatorsfältet i kmom02 och hur jag implementera användarhanteringen.
Men det var ändå en del saker som var annorlunda och jag fastnade på ganska mycket. Hade främst problem med att
få innehållet i en kommentar till uppdateringsformen. Valde att skicka med id och pageId som parametrar i konstruktorn
i CFormComment och på så sätt definera vad id är och vilken sida man är på. Sen hade jag ett problem i att visa kommentarerna
på rätt sida. Valde att skapa en ny metod i CDatabaseModel, "getPage". Men det var fortfarande problem med att visa kommentarerna
på sidan "me". Eftersom jag i me.php inte namnger routern för sidan "me" så vart det null i databasen. Jag döpte routern till "me"
och problemet var löst. 

Redovisning kmom03
------
####Vad tycker du om CSS-ramverk i allmänhet och vilka tidigare erfarenheter har du av dem?
Jag har alltid haft svårt för css och främst positionering i css så därför var det roligt att lära
sig om gridsystemet och hur man kan strukturera upp en sida. Det positiva är att 
ramverket innehåller allt det väsentliga, det är lättanvänt och ganska lätt att komma in i. Font-awesome
verkar ju vara ett väldigt bra verktyg för att slippa använda photoshop. 
Det negativa med att ha all css-kod i en fil är det kan ta lång tid att ladda då det laddas en massa kod
som är överflödig och ibland verkar det som att den inte laddar alls. Läste i forumet att det var flera
som hade samma problem. Hände mig också att det kunde vara lite opålitligt, antagligen något fel i koden 
antagligen. Om man fick till style.php och sen tillbaka till frontcontrollern så verkar det fungera av någon 
anledning.

####Vad tycker du om LESS, lessphp och Semantic.gs?
Ingenting jag jobbar med tidigare så det var nytt. Jag gillar LESS, det skiljer sig inte 
jättemycket från 'vanlig' css men det jag läste och provade verkar ändå ganska mycket smidigare.
Har inte så mycket att jämnföra med då jag inte hållt på med något css-ramverk tidigare och det är
svårt att sätta sig in i någon annans kod men det är något som skulle kunna hjälpa en mycket i framtiden.

####Vad tycker du om gridbaserad layout, vertikalt och horisontellt?
Som sagt gillade jag det gridbasarade systemet och det det var lätt att implementera. Bra att
vi fick lära oss lite om responsiva sidor. Testade lite de gamla sidorna man har gjort i de förra
kurserna och de var inte alls så bra anpassade för smartphones.

####Har du kommentarer kring Font Awesome, Bootstrap och Normalize?
Som sagt så gillade jag Font-Awesome och lekte runt ett tag med det. Kollade lite hastigt på
Bootstrap och det är något jag har fått höra mycket och se hur snygga lösningar den kan ge.

####Beskriv ditt tema, hut tänkte du när du gjorde det? Gjorde du några utsvävningar? 
Tyvärr vart det ett väldigt simpelt tema. Jag ligger efter lite och skulle gärna hålla på mera med layouten men
väljer att forsätta på nästa delmoment.


Redovisning kmom02
------
####Hur känns det att jobba med Composer?
Det gick väl inte så jättesmidigt till en början. Klonade inte Anax från github första gången så fick
lite svårt när jag skulle installera composer(fick köra utan "--no-dev" koden) och kunde sedan inte komma
åt 'Anax-MVC' direkt utan gå genom 'saxon/students/..' osv. Det fungerade i alla fall till slut. Gjorde om
det en gång och klonade från github och då gick det mycket bättre att följa instruktionerna.

####Hur var begreppen att förstå med klasser som kontroller som tjänster som dispatchas, fick du ihop allt?
Det var absolut inte lätt att förstå sig på det. Fick läsa igenom hur det fungerar några gånger och det tog
allt för lång tid för att få ihop kommentatorsfältet. Det har börjat klarna hur det går ihop nu. Sekvensdiagramet
i instruktionerna hjälpte verkligen. Till en början kändes nästan en del funktioner som 'magiska', man förstod inte
alls hur de kunde uppkomma men efter det börjar sitta. Verkligen ett detektivarbete som det står i instruktionerna...


###Implementationen
Att använda en dispatcher känns smidigt nu. Det jag hade lite problem med var att jag inte la till parametrar som 
definerade vilken sida man är på. Kikade runt i forumet för att se hur andra hade gått till väga för att definera detta
och såg att många hade använt sig av $this->url->create($pageId) i vyerna och sedan definerade vilken sida det är i me.php eller
index.php.

Control/model konceptet känns inte helt främmande då jag jobbat lite med det tidigare så det var inga större problem
Det var i vyerna jag hade ganska stora problem med hur jag skulle skicka med informationen om vilken sida man är på 
och vilket id kommentaren har. Definerade vilken sida man är på genom att definera det i me.php skicka med det till vyerna och 
vidare till controllern. 

Hade ändå fortfarande problem med hur det skulle gå att skilja mellan två sidor. Fick all kod att fungera förutom när
man skulle redigera en kommentar, då det alltid omdiregares till 'home'. Löste detta genom att lägga till .'&page='.$pageId 
i comments.tpl.php för att definera vilken sida det är. Kanske inte den bästa lösningen, men det löste problemet. 

Skulle till slut säga att jag har en bättre insyn i hur Anax-MVC-ramverk fungerar även om det inte är 100% än.
Det kommer förhoppningsvis snart.



Redovisning kmom01
------
####Vilken utvecklingsmiljö använder du?
Windows 8<br/>
Notepad++<br/>
WAMP<br/>
FileZilla<br/>
Chrome/Firefox

####Är du bekant med ramverk sedan tidigare?
Är ju såklart bekant med ramverket vi använde i förra kursen. Förutom det så har jag inte
jobbat med något annat ramverk.

####Är du sedan tidigare bekant med de lite mer avancerade begrepp som introduceras?
Inte riktigt, har jobbat med ett ramverk i ett projekt i en C#-kurs så känner igen
en del begrepp men har inte jättestor koll. Vi jobbade lite med factories, dependency injection 
osv. Fokus låg på att det inte skulle finnas en direkt koppling mellan databasen och 'användarinteraktionen'.
Dvs ha en 'controller' som ett mellanlager. Vi fick på samma sätt som den här kursen ett skal för 
att arbete i. Tyvärr var det så mycket fokus på att få koden att fungera att det inte vart så stor reflextion
i hur MVC fungerade så förhoppningsvis kommer det nu.

####Din uppfattning om Anax, och speciellt Anax-MVC?
Jag har gått från förvirrad till mindre förvirrad. Det tog ett tag att förstå strukturen
och det var lite svårt att hålla kolla på alla filer till en början. Läste igenom 
'anax-som-mvc-ramverk' 2-3 gånger för att verkligen förstå. Intressant hur frontcontroller fungerar,
ingenting som jag har stöt på tidigare så mycket intressant(när man väl förstod konceptet).
För att förstå hur t.ex. $app är 'kopplad' fick jag skriva upp dess väg från kontrollern genom
alla steg den tar för att kunna skapa en 'karta' över hur allting är sammansatt.
Förhoppningsviss kommer allting sitta snart under de närmsta uppgifterna. 
