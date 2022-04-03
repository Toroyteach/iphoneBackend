Here comes a few instructions which could help you whenever you need help haha.

You can have the Achievements triggers for both the lessons watched and comments written changed dynamically if you would like
to have lower or higher values to be used to get the result for a user.

The file responsible for this can be found in the config folder in achievements.php file
Here all you need to do is add the extra entry corresponding to its title or rather the 
that would be used to identify itself.

Noted:
I noticed the instructions said to listen to listen this events and not to worry about how the events itself is triggered. What i 
decided to do is listen to the Leesons watched event since this where the most required info is. With Comments i believe all commnets
needs a user as a requirement so counting the users comments would only make sense here.

I have an AchievemntService class in the Service folder where most of the data is handled to reduce the work done and the code 
written in the controller class.

Inside that serice class which implements an interphace, helps ensures the required data types of arrays and strings and int 
are returned and also contains methods necessary to handle the calculation to get the response.

I ran acouple of tests on the requirements of the achievements calculations to enure the right achievement is awarded to the right
achievement count for the lessons watched and commnets written. Together with awarding of the badges which should corresponde to the
achievements count. Also the necessaryy return types is gotten from the service class.

There infinite number of tests that can be written to run in this case scenario its only time that defines how many youl write.