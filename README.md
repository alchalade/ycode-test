# Ycode Airtable

## Notes
Firstly I dockerized the project for the case that you want to check it on your own local environment.
The goal of it was to prevent **but it works on my pc :)**

Use `ninanung/nginx-proxy` as reverse proxy if you own a M1 Mac 

Please add **127.0.0.1   ycode.local**  to your `/etc/hosts`


I worked on this test-assignment while I was also taking care of my kids and I was not able to commit each bit and piece but I hope you'll understand it.


My first impression about the assignment was; "okay its a form push it to the api, get data back from it and done", but after I got into I was positively suprised. Congrats, it was a great task.

### Your requests and what I did

- The website should be able to withstand thousands of visitors at one time.
  
  **MY PART** Without Swarm or Kubernetes it would be pretty hard to overstand simultaneously thousands of visitors even
  with Varnish and co. **:)** . However, I think your point was to avoid to pull data from Airtable on each request. I overcome the **rate_limit** of AirTable by putting the data into Redis. I created two commands for handling the synchronization.
  One is responsible for pushing up to 10 Members to Airtable, and the other one is downloading the data and put it into Redis.
  Both jobs are running each minute. 

  **PS:** I could use Spatie's scheduler package to schedule the commands in seconds-range to use 100% of the rate limit. But I thought it would be over engineering.

  
- The blue colour used on the H1 should be swapped out for #3C8999.

  **My PART** I add a customer color to `tailwind_config.js` and used it on the **H1** tag.



- Each field submitted via the form should be required except for photo.
- Photo uploads should be of type JPG only and be no bigger than 100MB.
  **MY PART** I use `vuelidate` for the form validation. As you already know it does not support
  image validation, TBH I did not try to extend it with a custom validation rule for the image. 
  I checked it both on JS side and on Laravel's side (RequestValidationRule) 
  

###What else could be done ? 
- Paginate the member list while adding them into cache
- I observed, that Airtable does not include the Name and Email fields when they are manually deleted from the source. 
  Basing on the E-mail I sent to my contact person Izabella, I assumed that the form is the only place where a member
  could be stored
- Add eslint to lint the Frontend.






----
## Rest of original Readme
Hi! Are you ready to join our team working on an innovative and exciting project? We are looking for a full-stack developer.

For the test assignment, we would like you to create a page which connects to Airtable and renders its data in a table format. It should also
include a form which on submission, data will be posted back to Airtable and appear in your table.

We have provided a base HTML layout for your table and form.

Use small commits and descriptive commit messages while working on the assignment. One commit solving one issue.

There are a few things you should take into consideration:

We have also created an example Airtable dataset for you to use. We require you to copy this dataset to your own Airtable
account by following these instructions:
1. Navigate to the example dataset by following the link "https://airtable.com/shrsffH1u5qtGmviu/tblazX8u4wWhOJQnT".
2. In the top right, you should see and click a button that says "Use this data".
3. Create or use an existing Airtable account to select a workspace and a base of "Create a new base....".
4. This data should now be copied into your own Airtable account.
5. You will also have to generate an Airtable API key by visiting "https://airtable.com/account".
6. After you have copied the example dataset and generated an API key, all other credentials can be found on "https://airtable.com/api". 

---

Use this repository as your starting point but **DO NOT** fork it. Create a private repository on GitHub for your application source code, push it and invite the username of "liamwalder" as a collaborator via "Settings > Manage access".
