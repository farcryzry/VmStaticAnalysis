package lab3;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;

import com.mongodb.BasicDBList;
import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.MongoClient;

public class MongoDBToMySQL {
	 static final String MYSQLDB_URL = "jdbc:mysql://localhost/cmpe283";
	 static final String MYSQLUSER = "group3";
	 static final String MYSQLPASS = "sjsugroup3";
	 static final String MONGODBPATH = "/Applications/mongodb-osx-x86_64-2.6.0/bin/mongod --dbpath /Users/lingzhang/Documents/mongoDBdata/db";
	 
public static void main (String[] args) throws Exception{
		String selectedvm="T03-VM02-Lin-Ling";
		String selectedtime= "2014-04-20 00:00:01";
		String selectedendtime= "2014-04-20 00:01:01";
		
        //open mongodb
		String cmd = MONGODBPATH;
		System.out.println("Opening mongoDB...");
		Process process = Runtime.getRuntime().exec(cmd);
		
		//connect to mongodb and query data
		System.out.println("Connecting to mongoDB...");
		MongoClient mongoClient = new MongoClient( "localhost" , 27017 );
		
		DB db = mongoClient.getDB( "mydb" );
		
		DBCollection coll = db.getCollection("statics");
	    //condition list：  
	    BasicDBList condList = new BasicDBList();     
	    //time within range 
	    BasicDBObject cond1= new BasicDBObject();  
	    cond1.append("time",new BasicDBObject("$gte",selectedtime));    
	    cond1.append("time",new BasicDBObject("$lt",selectedendtime));  	      
	    //vm is selected vm
	    BasicDBObject cond2= new BasicDBObject();  	      
	    cond2.append("vm_name",selectedvm);  	      
	    //combine 2 condition together 
	    condList.add(cond1);  	      
	    condList.add(cond2);  	      
	    BasicDBObject cond= new BasicDBObject();        
	    cond.put("$and", condList);   
	    //query data  
	    DBCursor cursor= coll.find(cond);  
		

		// calculate average cpu usage 
		double sumcpu=0;
		int summemory=0;
		int count=0;
		while (cursor.hasNext()) {
		    BasicDBObject obj = (BasicDBObject) cursor.next();
		    System.out.println(obj.getString("cpu") + ", " + obj.getString("memory"));
		    sumcpu += obj.getDouble("cpu");
		    summemory +=obj.getInt("memory");
		    count +=1;
		}
		cursor.close();
		double avgcpu=sumcpu/count;
		int avgmemory=summemory/count;
		System.out.println("average cpu usage is " +avgcpu + "% CPU");
		System.out.println("average memory usage is " +avgmemory + " Mb");
				
	    //close mongodb process 	
		process.destroy();
		
		// connect to MySQL database
		System.out.println("Connecting to MySQL database...");
	    Connection conn = DriverManager.getConnection(MYSQLDB_URL,MYSQLUSER,MYSQLPASS);

	    // Execute a insert
	    System.out.println("Start to insert data...");	    	    
	    String sql;
	    sql = "insert into avg_stats (vm_name,time, avg_cpu, avg_memory) values (?,?,?,?) ";
	    PreparedStatement prest=conn.prepareStatement(sql);
	    prest.setString(1, selectedvm);
	    prest.setString(2, selectedtime);
	    prest.setDouble(3, avgcpu);
	    prest.setInt(4, avgmemory);
	    prest.executeUpdate(); 
        System.out.println("insert data succesfully"); 
	    
	    conn.close();
	}

}
