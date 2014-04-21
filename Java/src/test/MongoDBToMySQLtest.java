package test;

import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.MongoClient;

public class MongoDBToMySQLtest {
	
public static void main (String[] args) throws Exception{
		
        //open mongodb
		String cmd = "/Applications/mongodb-osx-x86_64-2.6.0/bin/mongod --dbpath /Users/lingzhang/Documents/mongoDBdata/db";
		Process process = Runtime.getRuntime().exec(cmd);
		
		//connect to mongodb and query data
		MongoClient mongoClient = new MongoClient( "localhost" , 27017 );
		
		DB db = mongoClient.getDB( "mydb" );
		
		DBCollection coll = db.getCollection("statics");
		
		BasicDBObject query = new BasicDBObject("vm_name", "T03-VM02-Lin-Ling");
		DBCursor cursor = coll.find(query);
		//double sum_cpu=0;
		while(cursor.hasNext())
		{
			System.out.println(cursor.next());
			BasicDBObject obj = (BasicDBObject) cursor.curr();
		    System.out.println(obj.getDouble("cpu"));
		   
		}
		cursor.close();
		
		BasicDBObject field = new BasicDBObject("cpu", 1);
		cursor = coll.find(query,field);
		double sum_cpu=0;
		int count=0;
		while (cursor.hasNext()) {
		    BasicDBObject obj = (BasicDBObject) cursor.next();
		    System.out.println(obj.getString("cpu"));
		    sum_cpu += obj.getDouble("cpu");
		    count +=1;
		}
		double ave_cpu=sum_cpu/count;
		System.out.println("average cpu usage is " +ave_cpu + "% CPU");
		
		
	 //close mongodb process 	
		process.destroy();

	}

}
