package com.project.captchit2;

import java.util.ArrayList;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.telephony.TelephonyManager;
import android.widget.ProgressBar;

import com.project.commonUtility.AlertDialogManager;
import com.project.commonUtility.ConnectionDetector;
import com.project.commonUtility.CustomHttpClient;
import com.project.commonUtility.SessionManager;

@SuppressLint("NewApi")
public class Splash extends Activity{

	ProgressBar progressBar;
	private int progressBarStatus = 0;
	Intent openMain ;
	ConnectionDetector cd;
	String imei,name,mobileno,emailid;
	SessionManager session;
	String url="http://103.12.211.176/~captchit/imeiValidation.php";	//URL to check is user already registered. Checks users IMEI number
	
	@TargetApi(Build.VERSION_CODES.GINGERBREAD)
	@SuppressLint("NewApi")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.splash);
		cd = new ConnectionDetector(this);
		TelephonyManager tm = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
		imei= tm.getDeviceId();
		progressBar=(ProgressBar)findViewById(R.id.progressBar1);
		session = new SessionManager(this);
		 if (android.os.Build.VERSION.SDK_INT > 9)
				StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().detectAll().build());
		
		if(cd.isConnectingToInternet())
		{		
			
			new loadData().execute(url);
			try{
					
					Thread timer = new Thread(){
					    @Override
						public void run(){
					        
					            try {
										sleep(1000);
								
							            while(progressBarStatus < 5000){
							                Splash.this.runOnUiThread(new Runnable(){
							                    	@Override
													public void run()
								                    {
								                        progressBar.setProgress(progressBarStatus);
								                        progressBarStatus += 100;
								                    }
							                });
							            }
							     } catch (InterruptedException e) {
											// TODO Auto-generated catch block
											e.printStackTrace();
								}
					    }
					};
					
					timer.start();
					 }catch(Exception e){
						 	
				            e.printStackTrace();
				        }finally{
				        }
		}
		else
		{
			AlertDialogManager adm=new AlertDialogManager();
			adm.showAlertDialog(this, "Error...", "Check Internet Connection/Username Password", false);
			try {
				Thread.sleep(1000);
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
//			finish();
		}
		
        
	}


	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
		
		
	}

	public class loadData extends AsyncTask<String, Integer, Boolean>
	{

		
		
		@Override
		protected void onPreExecute() {
			// TODO Auto-generated method stub
			super.onPreExecute();
		}

		@Override
		protected Boolean doInBackground(String... url) {
			// TODO Auto-generated method stub
			ArrayList<NameValuePair>postParameters=new ArrayList<NameValuePair>();
			
			postParameters.add(new BasicNameValuePair("imei", imei));
			
//			//String response1 = null;
//			
//			 try{
//			        HttpClient httpclient = new DefaultHttpClient();
//			        HttpPost httppost = new      
//			        HttpPost("http://103.12.211.176/~captchit/imeiValidation.php"); 
//			        httppost.setEntity(new UrlEncodedFormEntity(postParameters));
//			        HttpResponse response = httpclient.execute(httppost);
//			        Log.i("postData", response.getStatusLine().toString());
//			    }
//
//			    catch(Exception e)
//			    {
//			    	//Toast.makeText(Send_Data.this, "Error in http connection ", Toast.LENGTH_LONG).show();
//			        Log.e("log_tag", "Error in http connection "+e.toString());
//			    }    
			
			 String response;
			try {
				response = CustomHttpClient.executeHttpPost(url[0],postParameters);
				String result=response.toString();
				JSONArray jArray;
				
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
							session.createSession(name, mobileno, emailid);
					    }
					  return true; 
				}
				else
				{
					// username / password doesn't match or empty
					return false;
				}
			} catch (Exception e) {
				// TODO Auto-generated catch block
				return false;
			}
		}

		@Override
		protected void onPostExecute(Boolean result) {
			// TODO Auto-generated method stub
			super.onPostExecute(result);
			if(result)
			{
				openMain = new Intent(Splash.this, Photo_intent.class);
				startActivity(openMain);
				finish();
			}
			else 
			{
				/**
				 * call login activity
				 */
				Intent openLogin = new Intent(Splash.this, LoginActivity.class);
				startActivity(openLogin);
				finish();
			}
		}
		
		
	}
	
}
