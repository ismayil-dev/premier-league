# **Premier League Match Simulation**

 clone git repo by using following command:  
`git clone https://github.com/softisoDev/price-parser.git`

## **Short description**
<p> -There are four teams in the league
</p>
<p> -Standing has (scoring, points, goal difference, etc.) will be the same as the rules of the Premier League </p>
<p> -You can play match week by week or play all weeks at once </p>
<p> -Scores generated randomly </p>
<p> -Standing are updated due to match results</p>

## **About championship prediction**
<p>
When you play every week you will see "Championship Predictions" table. It automatically calculate probability by custom algorithm by given match results and standings. 
Actually there are many different ways and algorithms to predict championship because of given data. For simplicity I wrote custom algorithm
that calculates probability of champions based on <strong>win games, score and GF (goal for)</strong> data. 
</p>
<p>
Furthermore to get high prediction result we can use <strong>Random forest</strong>, <strong>K-nearest</strong>, <strong>Linear or Logistics regression</strong> algorithms.
Of course it will take much time and require large datasets.
</p>

## **Installation**
<p>Laravel version: 9.0</p>

Project is Dockerized and used [Sail](https://laravel.com/docs/9.x/sail).

<p>After clone repository go to project directory and run </p>

### **Docker**
<p>If you're in Windows environment and use WSL based on Ubuntu for dockerization you need to run following command:</p>

`./vendor/bin/sail up -d`

For more information [Laravel Getting Started On Windows](https://laravel.com/docs/9.x/installation#getting-started-on-windows)


### **Alias**: 

`alias sail='bash vendor/bin/sail'`

### **Project**

`sail composer u`

`sail npm i`

`sail npm run dev`

`cd copy .env.example .env`

`sail artisan key:generate`

### **Database configurations**
You need create two databases. First for project and second is for testing. You can configure `.env.testing` to run tests

For project please configure your `.env` file

After configure environments run

`sail artisan migrate --seed`
