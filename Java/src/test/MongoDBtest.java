package test;

import java.util.List;
import java.util.Set;

import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.MongoClient;

public class MongoDBtest {
	
	public static void main (String[] args) throws Exception{
		


		
		
		MongoClient mongoClient = new MongoClient( "localhost" , 27017 );
		
		List<String> dbs = mongoClient.getDatabaseNames();
		for(String dbname : dbs)
		{
			System.out.println(dbname);
		}
		
		DB db = mongoClient.getDB( "mydb" );
		Set<String> colls = db.getCollectionNames();
		for (String s : colls)
		{
		    System.out.println(s);
		}
		
		DBCollection coll = db.getCollection("user");
		
		BasicDBObject query = new BasicDBObject("age", 26);
		DBCursor cursor = coll.find(query);
		while(cursor.hasNext())
		{
		   System.out.println(cursor.next());
		}
		cursor.close();
		
		query = new BasicDBObject("age", new BasicDBObject("$gt", 18));  
		// e.g. find all where age > 18
	    cursor = coll.find(query);
		while(cursor.hasNext())
		{
		   System.out.println(cursor.next());
		}
		cursor.close();
		
	}
	

}
