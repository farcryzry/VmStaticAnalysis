package lab3;


import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.util.ArrayList;
import java.util.Arrays;

import com.mongodb.BasicDBList;
import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.MongoClient;

public class MongoToMySQLManager {
	 
	 static final String VMIP1="130.65.133.148"; // need to reset!!!! and make php config ip same as here
	 static final String VMIP2="130.65.133.194"; // need to reset!!!! and make php config ip same as here
	 static final ArrayList<String> VMIPS= new ArrayList<String>(Arrays.asList(VMIP1,VMIP2));
	 static final String MYSQLDB_URL = "jdbc:mysql://localhost/cmpe283";
	 static final String MYSQLUSER = "group3";
	 static final String MYSQLPASS = "sjsugroup3";
	 static final String MONGODBPATH = "/Applications/mongodb-osx-x86_64-2.6.0/bin/mongod --dbpath /Users/lingzhang/Documents/mongoDBdata/db";	
	 static final boolean LocalMongo=true;
	 static final String MongoURL="localhost";
	 static final String MongoDBName="lingdb";
	 static final String MongoDBCollection="vmstatics";
	 static final int SleepInterval=10000;   //need to reset!!!
	 static final int RetrieveNubmerLimit=2; //should be SleepInterval/5000

	
	public static void main (String[] args) throws Exception {
		//if use local monog, open mongodb
		Process process;
		if (LocalMongo) {
		String cmd = MONGODBPATH;
		System.out.println("Opening mongoDB...");
		process = Runtime.getRuntime().exec(cmd);
		}
		while(true){
		System.out.println("Connecting to mongoDB...");
		MongoClient mongoClient = new MongoClient( MongoURL , 27017 );		
		DB mongodb = mongoClient.getDB( MongoDBName );	
		DBCollection mongocoll = mongodb.getCollection(MongoDBCollection);
		System.out.println("Connecting to MySQL...");
		Connection mysqlconn = DriverManager.getConnection(MYSQLDB_URL,MYSQLUSER,MYSQLPASS);
		System.out.println("Getting CPU data from mongoDB to MySQL...");
		
		for(String vmip : VMIPS){
		getAndStoreCPUs(mongocoll,vmip,mysqlconn);
		getAndStoreMemorys(mongocoll,vmip,mysqlconn);
		getAndStoreIOs(mongocoll,vmip,mysqlconn);
		getAndStoreThreads(mongocoll,vmip,mysqlconn);
		}
		
		System.out.println("Closing connection to MySQL...");
		mysqlconn.close();
		System.out.println("Closing MongoDB...");
		if (LocalMongo){
		process.destroy();
		}
		
		System.out.println("Wait for " + SleepInterval/1000 +" second to retrieve data again...");
		Thread.sleep(SleepInterval);
		}
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
	    //query data sort with time stamp and limit to last RetrieveNubmerLimit records
	    DBCursor cursor= mongocoll.find(cond).sort(new BasicDBObject("@timestamp",-1)).limit(RetrieveNubmerLimit); 
	    
	    //get data from query result and insert into MySQL cpu table
	    Double percent;
	    String time;
		while (cursor.hasNext()) {		
		    BasicDBObject obj = (BasicDBObject) cursor.next();
		    percent=Double.parseDouble(obj.getString("percent"));
		    	    
		    time = obj.getString("@timestamp");
		    System.out.println(vmip+":" + time+ ": "+ percent );
		    String sql= "insert into cpu (ip, time, percent) values (?,?,?) ";
		    PreparedStatement prest=mysqlconn.prepareStatement(sql);
		    prest.setString(1, vmip);
		    prest.setString(2, time);
		    prest.setDouble(3, percent);
		    prest.executeUpdate();

		}
		cursor.close();	   
	}
	
	public static void getAndStoreMemorys(DBCollection mongocoll, String vmip, Connection mysqlconn )
			throws Exception{
			    //condition list：  
			    BasicDBList condList = new BasicDBList();     
			    BasicDBObject cond1= new BasicDBObject();  
			    cond1.append("ip", vmip);    	      
			    BasicDBObject cond2= new BasicDBObject();  	      
			    cond2.append("type","memory");  	      
			    //combine 2 condition together 
			    condList.add(cond1);  	      
			    condList.add(cond2);  	      
			    BasicDBObject cond= new BasicDBObject();        
			    cond.put("$and", condList); 
			    //query data sort with time stamp and limit to last RetrieveNubmerLimit records
			    DBCursor cursor= mongocoll.find(cond).sort(new BasicDBObject("@timestamp",-1)).limit(RetrieveNubmerLimit); 
			    
			    //get data from query result and insert into MySQL cpu table
			    int free;
			    int used;
			    String time;
			    double rate;
				while (cursor.hasNext()) {		
				    BasicDBObject obj = (BasicDBObject) cursor.next();
				    free=Integer.parseInt(obj.getString("free"));
				    used=Integer.parseInt(obj.getString("used"));
				    rate=Double.parseDouble(obj.getString("rate"));
				    time = obj.getString("@timestamp");				    
				    System.out.println(vmip+":" + time+ ": "+ free + ", " + used);
				    String sql= "insert into memory (ip, time, free, used, rate) values (?,?,?,?,?) ";
				    PreparedStatement prest=mysqlconn.prepareStatement(sql);
				    prest.setString(1, vmip);
				    prest.setString(2, time);
				    prest.setInt(3, free);
				    prest.setInt(4, used);
				    prest.setDouble(5, rate);
				    prest.executeUpdate();

				}
				cursor.close();	   
			}
	
	public static void getAndStoreIOs(DBCollection mongocoll, String vmip, Connection mysqlconn )
			throws Exception{
			    //condition list：  
			    BasicDBList condList = new BasicDBList();     
			    BasicDBObject cond1= new BasicDBObject();  
			    cond1.append("ip", vmip);    	      
			    BasicDBObject cond2= new BasicDBObject();  	      
			    cond2.append("type","io");  	      
			    //combine 2 condition together 
			    condList.add(cond1);  	      
			    condList.add(cond2);  	      
			    BasicDBObject cond= new BasicDBObject();        
			    cond.put("$and", condList); 
			    //query data sort with time stamp and limit to last RetrieveNubmerLimit records
			    DBCursor cursor= mongocoll.find(cond).sort(new BasicDBObject("@timestamp",-1)).limit(RetrieveNubmerLimit); 
			    
			    //get data from query result and insert into MySQL cpu table
			    double tps;
			    double read;
			    String time;
			    double write;
				while (cursor.hasNext()) {		
				    BasicDBObject obj = (BasicDBObject) cursor.next();
				    tps=Double.parseDouble(obj.getString("tps"));
				    read=Double.parseDouble(obj.getString("kbread-s"));
				    write=Double.parseDouble(obj.getString("kb-wrtn-s"));
				    time = obj.getString("@timestamp");				    
				    System.out.println(vmip+":" + time+ ": "+ tps + ", " + read + ", " + write);
				    String sql= "insert into io (ip, time, tps, readps, writeps) values (?,?,?,?,?) ";
				    PreparedStatement prest=mysqlconn.prepareStatement(sql);
				    prest.setString(1, vmip);
				    prest.setString(2, time);
				    prest.setDouble(3, tps);
				    prest.setDouble(4, read);
				    prest.setDouble(5, write);
				    prest.executeUpdate();

				}
				cursor.close();	   
			}
	
	public static void getAndStoreThreads(DBCollection mongocoll, String vmip, Connection mysqlconn )
			throws Exception{
			    //condition list：  
			    BasicDBList condList = new BasicDBList();     
			    BasicDBObject cond1= new BasicDBObject();  
			    cond1.append("ip", vmip);    	      
			    BasicDBObject cond2= new BasicDBObject();  	      
			    cond2.append("type","thread");  	      
			    //combine 2 condition together 
			    condList.add(cond1);  	      
			    condList.add(cond2);  	      
			    BasicDBObject cond= new BasicDBObject();        
			    cond.put("$and", condList); 
			    //query data sort with time stamp and limit to last RetrieveNubmerLimit records
			    DBCursor cursor= mongocoll.find(cond).sort(new BasicDBObject("@timestamp",-1)).limit(RetrieveNubmerLimit); 
			    
			    //get data from query result and insert into MySQL cpu table
			    int thread;
			    String time;

				while (cursor.hasNext()) {		
				    BasicDBObject obj = (BasicDBObject) cursor.next();
				    thread=Integer.parseInt(obj.getString("total"));

				    time = obj.getString("@timestamp");				    
				    System.out.println(vmip+":" + time+ ": "+ thread);
				    String sql= "insert into thread (ip, time, total) values (?,?,?) ";
				    PreparedStatement prest=mysqlconn.prepareStatement(sql);
				    prest.setString(1, vmip);
				    prest.setString(2, time);
				    prest.setInt(3, thread);
				    prest.executeUpdate();

				}
				cursor.close();	   
			}



	
	
}
