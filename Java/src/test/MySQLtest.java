package test;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;

public class MySQLtest {
	
	public static void main(String[] args) {
		 Connection con = null;
	        Statement st = null;
	        ResultSet rs = null;

	        String url = "jdbc:mysql://localhost/funtack";
	        String user = "group12";
	        String password = "sjsugroup12";

	        try {
	            con = DriverManager.getConnection(url, user, password);
	            st = con.createStatement();
	            ResultSet rs1 = st.executeQuery("SELECT VERSION()");

	            if (rs1.next()) {
	                System.out.println(rs1.getString(1));
	            }
	            
	            //STEP 4: Execute a query
	            System.out.println("Creating statement...");
	            String sql;
	            sql = "SELECT * FROM users";
	            rs = st.executeQuery(sql);

	            //STEP 5: Extract data from result set
	            while(rs.next()){
	               //Retrieve by column name
	               int id  = rs.getInt("user_id");
	               String first = rs.getString("first_name");
	               String last = rs.getString("last_name");

	               //Display values
	               System.out.print("ID: " + id);
	               System.out.print(", First: " + first);
	               System.out.println(", Last: " + last);
	            }
	            //STEP 6: Clean-up environment
	            rs.close();
	            st.close();
	            con.close();

	        } catch (SQLException ex) {
	            Logger lgr = Logger.getLogger(MySQLtest.class.getName());
	            lgr.log(Level.SEVERE, ex.getMessage(), ex);

	        } finally {
	            try {
	                if (rs != null) {
	                    rs.close();
	                }
	                if (st != null) {
	                    st.close();
	                }
	                if (con != null) {
	                    con.close();
	                }

	            } catch (SQLException ex) {
	                Logger lgr = Logger.getLogger(MySQLtest.class.getName());
	                lgr.log(Level.WARNING, ex.getMessage(), ex);
	            }
	        }
		
	}

}
