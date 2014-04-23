package lab3;


import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.Date;

import com.mongodb.BasicDBList;
import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.MongoClient;

public class MongoToMySQLManager {
	 static final String MYSQLDB_URL = "jdbc:mysql://localhost/cmpe283";
	 static final String MYSQLUSER = "group3";
	 static final String MYSQLPASS = "sjsugroup3";
	 static final String MONGODBPATH = "/Applications/mongodb-osx-x86_64-2.6.0/bin/mongod --dbpath /Users/lingzhang/Documents/mongoDBdata/db";	
	 static final String VMIP1="172.16.35.135";

	
	public static void main (String[] args) throws Exception {
		//open mongodb
		String cmd = MONGODBPATH;
		System.out.println("Opening mongoDB...");
		Process process = Runtime.getRuntime().exec(cmd);
		System.out.println("Connecting to mongoDB...");
		MongoClient mongoClient = new MongoClient( "localhost" , 27017 );		
		DB mongodb = mongoClient.getDB( "lingdb" );	
		DBCollection mongocoll = mongodb.getCollection("vmstatics");
		System.out.println("Connecting to MySQL...");
		Connection mysqlconn = DriverManager.getConnection(MYSQLDB_URL,MYSQLUSER,MYSQLPASS);
		System.out.println("Getting CPU data from mongoDB to MySQL...");
		getAndStoreCPUs(mongocoll,VMIP1,mysqlconn);
		
		System.out.println("Closing connection to MySQL...");
		mysqlconn.close();
		System.out.println("Closing MongoDB...");
		process.destroy();
	}
	
	

	
	public static void getAndStoreCPUs(DBCollection mongocoll, String vmip, Connection mysqlconn )
	throws Exception{
	    //condition list：  
	    BasicDBList condList = new BasicDBList();     
	    BasicDBObject cond1= new BasicDBObject();  
	    cond1.append("ip", vmip);    	      
	    BasicDBObject cond2= new BasicDBObject();  	      
	    cond2.append("type","cpu");  	      
	    //combine 2 condition together 
	    condList.add(cond1);  	      
	    condList.add(cond2);  	      
	    BasicDBObject cond= new BasicDBObject();        
	    cond.put("$and", condList); 
	    //DBCursor cursor= mongocoll.find(cond);
	    //query data sort with time stamp and limit to last 60 records
	    DBCursor cursor= mongocoll.find(cond).sort(new BasicDBObject("@timestamp",-1)).limit(60); 
	    
	    //get data from query result and insert into MySQL cpu table
	    Double us;
	    Double sy;
	    String time;
		while (cursor.hasNext()) {		
		    BasicDBObject obj = (BasicDBObject) cursor.next();
		    us=Double.parseDouble(obj.getString("us"));
		    sy=Double.parseDouble(obj.getString("sy"));		    
		    time = obj.getString("@timestamp");
		    //SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd hh:mm:ss.SSSSSS");
		    //Date date =sdf.parse(time);
		    //Timestamp ts = Timestamp.valueOf("2014-04-22 07:16:41.626000");
		    System.out.println(vmip+":" + time+ ": "+ us + ", " + sy);
		    //System.out.println(ts);
		    //System.out.println(date);
		    String sql= "insert into cpu (ip, time, us, sy) values (?,?,?,?) ";
		    PreparedStatement prest=mysqlconn.prepareStatement(sql);
		    prest.setString(1, vmip);
		    prest.setString(2, time);
		    prest.setDouble(3, us);
		    prest.setDouble(4, sy);
		    prest.executeUpdate();

		}
		cursor.close();	   
	}
	
	public static void getAverageMemory(){
		
	}

	public static void getAverageNetwork(){
		
	} 
	
	public static void getAverageDisk(){
		
	} 
	
	public static void getAverageUptime(){
		
	} 
	
	public void insertToMySQL(){
		
	}
	
	
}
