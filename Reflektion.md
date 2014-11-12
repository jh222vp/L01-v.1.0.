L01-v.1.0.
==========

Repositorie för labb1 i webbteknik 2

#Reflektioner

###Vad tror Du vi har för skäl till att spara datat i JSON-format?
Ett av skälen är att vi vill kunna presentera data i textform och eftersom JSON är strukturerat på i princip samma sätt som t.ex. interna Javascript-objekt så är JSON universal, enkelt och simpelt att arbeta och hantera.

###Olika jämförelsesiter är flitiga användare av webbskrapor. Kan du komma på fler typer av tillämplingar där webbskrapor förekommer?
Vid analys av olika hemsidor eller när man vill föra statistik över data på önskade hemsidor. Jag kan också tänka mig att webbskrapor används flitigt av hackers/crackers som luskar reda på epost-adresser, användarnamn och annat matnyttigt. Dessa används troligen också för att kräla runt på önskad hemsida för hitta backdörrar och liknande.

###Hur har du i din skrapning underlättat för serverägaren?
Cachar sidan i en lokal fil så att skrapningen endast körs var 5e minut. Detta gör att belastningen minskar på servern då man inte behöver köra om skrapan gång på gång för att se resultat.

###Vilka etiska aspekter bör man fundera kring vid webbskrapning?
Försöka undvika att skrapa sådant som kan uppfattas som känsligt. (vad som uppfattas som känsligt lämnar jag åt etik och moral kursen). Man skulle även kunna försöka utföra skrapningen då det ligger som minst trafik på servern så man inte förstör för ägaren av hemsidan. Att prata med server/hemsida ägaren kan nog också vara en god idé. Diskutera lite hur man kan göra skrapningen så smärtfri som möjligt.

###Vad finns det för risker med applikationer som innefattar automatisk skrapning av webbsidor? Nämn minst ett par stycken!
DOS och DDOS ifall många människor väljer att skrapa samma sida samtidigt så ökar trycket och belastningen på den skrapande sidan. I och med att de är automatiska så körs de av sig själv, ingen hänsyn finns om det börjar gå långsamt eller servern slöas ned. Så som min applikation är skriven så måste också koden ändras om koden på hemsidan ändras.

###Tänk dig att du skulle skrapa en sida gjord i ASP.NET WebForms. Vad för extra problem skulle man kunna få då?
Man måste lura sidan att man faktiskt klickat på en knapp (gjort en postback) samt skicka med en view-state (fejka en)

###Välj ut två punkter kring din kod du tycker är värd att diskutera vid redovisningen. Det kan röra val du gjort, tekniska lösningar eller lösningar du inte är riktigt nöjd med.
Bästa optimeringsättet för en webskarapa? Min skarpa är byggd med endast 3 olika filer (+ en cache), där index filen just nu sköter det mesta. Vad är bästa sättet att bygga dessa på? Bästa språk?

###Hitta ett rättsfall som handlar om webbskrapning. Redogör kort för detta.
EF CULTURAL TRAVEL BV VS. ZEFER CORPORATION - http://www.internetlibrary.com/pdf/efculturaltravel-zefer-1-cir.pdf
En resebyrå stämde ett konkurerande bolag som skrapat deras prislista för att sedan kunna sätta egna, bättre priser på sin hemsida. Domaren ansåg att det faktum att denna skrapning inte välkomnades av webbplatsens ägare inte var tillräcklig för att göra det "obehöriga" i syfte till federal hackning lagar.

###Känner du att du lärt dig något av denna uppgift?
Roligt att lära sig bygga en skrapa men tråkigt att den var så tidskrävande under testningarna.
