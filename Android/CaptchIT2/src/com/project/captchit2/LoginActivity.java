package com.project.captchit2;

import java.net.SocketTimeoutException;
import java.net.UnknownHostException;
import java.util.ArrayList;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.project.commonUtility.AlertDialogManager;
import com.project.commonUtility.CustomHttpClient;
import com.project.commonUtility.SessionManager;


public class LoginActivity extends Activity
{
   String name,mobileno,emailid,imei;
   
   EditText txtUsername, txtPassword;
   Button btnLogin1;
   
   AlertDialogManager alert = new AlertDialogManager();
   SessionManager session;
   
    String response=null;
	String url="http://103.12.211.176/~captchit/user_login.php";
	ArrayList<NameValuePair>postParameters;
	String userid, password;
	ProgressDialog progressDialog;
	Boolean result1=false;
	
	@TargetApi(Build.VERSION_CODES.GINGERBREAD)
	@SuppressLint("NewApi")
	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);
		
		
		/**
		 *   get imei using TelephonyManager
		 */
		TelephonyManager tm = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
		imei= tm.getDeviceId();
		
		 if (android.os.Build.VERSION.SDK_INT > 9)
				StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().detectAll().build());
		 session = new SessionManager(getApplicationContext()); 
		 txtUsername = (EditText) findViewById(R.id.txtUsername);
	     txtPassword = (EditText) findViewById(R.id.txtPassword); 
	     btnLogin1 = (Button) findViewById(R.id.btnLogin);
	     
	     btnLogin1.setOnClickListener(new View.OnClickListener() {
				
				@Override
				public void onClick(View arg0) {
					// Get username, password from EditText
					 userid = txtUsername.getText().toString();
					 password = txtPassword.getText().toString();
					
					/**
					 * send login data for checking to server 
					 */
					postParameters=new ArrayList<NameValuePair>();
					postParameters.add(new BasicNameValuePair("username", String.valueOf(userid)));
					postParameters.add(new BasicNameValuePair("password", String.valueOf(password)));
					postParameters.add(new BasicNameValuePair("imei", imei));
					new ExecuteLogin().execute(url);
					
				}
			});
	}
	
	public class ExecuteLogin extends AsyncTask<String, Integer, Boolean>
	{

    	

		@Override
		protected void onPreExecute() {
			// TODO Auto-generated method stub
			super.onPreExecute();
			 progressDialog=ProgressDialog.show(LoginActivity.this, "Wait", "Please Wait while Validating username password");
		}
		@Override
		protected Boolean doInBackground(String... url) {
			// TODO Auto-generated method stub
			
			try {
				 
				 response=CustomHttpClient.executeHttpPost(url[0],postParameters);
				 String result=response.toString();
				 JSONArray jArray;
				 if(userid.trim().length() > 0 && password.trim().length() > 0)
				 {
					 	jArray = new JSONArray(result);
							if (jArray.length()>=1) 
							{
									
									/**
									 * initialize array
									 */
									for (int a = 0; a < jArray.length(); a++) 
									{
										JSONObject json_data = jArray.getJSONObject(a);
										name = json_data.getString("name");
										mobileno = json_data.getString("mobileno");
										emailid = json_data.getString("emailid");
								    }
								    return true;
							}
							else
							{
								// username / password doesn't match or empty
								return false;
							}
				 }
				 else
				 {
						// user didn't entered username or password
						// Show alert asking him to enter the details
					 	return false;
				}
			
		}
		catch(SocketTimeoutException e)
		{
			Log.e("Got_ID", ""+e.getMessage());
			return false;
			//alert.showAlertDialog(LoginActivity.this, "Timeout...", "Check internet connection", false);
		}
		catch (UnknownHostException e)
		{
			Log.e("Got_ID", ""+e.getMessage());
			return false;
			//alert.showAlertDialog(LoginActivity.this, "Unable to resolve Host..", "Check internet connection", false);
		}
		catch (Exception e) 
		{
			Log.e("Got_ID", ""+e.getMessage());
			e.printStackTrace();
			return false;
		}
			
			
			
	}
		
		@Override
		protected void onPostExecute(Boolean result) 
		{
			// TODO Auto-generated method stub
			super.onPostExecute(result);
			progressDialog.dismiss();
			result1=result;
			
			if(result1)
			{
				session.createSession(name, mobileno, emailid);
				
				// Staring MainActivity
				Intent i = new Intent(getApplicationContext(), Photo_intent.class);
				//i.putExtra("", );
				startActivity(i);
				finish();
			}
			else
			{
				alert.showAlertDialog(LoginActivity.this, "Error...", "Check Internet Connection/Username Password", result1);
			}
		}
	}
	
	
}
