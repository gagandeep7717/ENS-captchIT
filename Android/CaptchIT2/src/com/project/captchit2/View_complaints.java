package com.project.captchit2;

import java.net.SocketTimeoutException;
import java.net.UnknownHostException;
import java.util.ArrayList;
import java.util.HashMap;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import android.annotation.TargetApi;
import android.app.Activity;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.webkit.WebView;
import android.widget.Button;

import com.project.commonUtility.AlertDialogManager;
import com.project.commonUtility.CustomHttpClient;
import com.project.commonUtility.SessionManager;

@TargetApi(Build.VERSION_CODES.GINGERBREAD)
public class View_complaints extends Activity{

	
	SessionManager session;
	HashMap<String , String> map;
	ArrayList<NameValuePair>postParameters;
	String mobileno,response;
	String mobile_list[],location_list[],landmark_list[],type_list[],status_list[],date_list[];
	AlertDialogManager alert;
	WebView viewAll;
	StringBuffer data;
	WebView engine;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.view_complaints);
		if (android.os.Build.VERSION.SDK_INT > 9)
			StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().detectAll().build());
		
		session = new SessionManager(this);
		map=session.getUserDetails();
		mobileno = map.get(SessionManager.KEY_MOBILE_NO);
		alert = new AlertDialogManager();
		postParameters = new ArrayList<NameValuePair>();
		postParameters.add(new BasicNameValuePair("mobileno", mobileno));
		
		 data = new StringBuffer("<html>");
		 engine = (WebView) findViewById(R.id.webView1);
		data.append("<body><table border=2>");
    	data.append("<tr> <td>Location </td><td> Landmark </td><td>Type</td><td>status</td><td>Date</td></tr>");
    	
		init();
		
		Button back =(Button)findViewById(R.id.btnView_back);
		back.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
				finish();
			}
		});
	}

	private void init() {
		// TODO Auto-generated method stub
		try {
			 
			 response=CustomHttpClient.executeHttpPost("http://103.12.211.176/~captchit/get_complaints.php",postParameters);
			 String result=response.toString();
			 JSONArray jArray;
			
				 	jArray = new JSONArray(result);
				 	
				 	mobile_list = new String[jArray.length()]; 
				 	location_list = new String[jArray.length()];
				 	landmark_list = new String[jArray.length()];
				 	type_list = new String[jArray.length()];
				 	status_list  = new String[jArray.length()];
				 	date_list = new String[jArray.length()];
						if (jArray.length()>=1) 
						{
							
								/**
								 * initialize array
								 */
								for (int a = 0; a < jArray.length(); a++) 
								{
									JSONObject json_data = jArray.getJSONObject(a);
									location_list[a] = json_data.getString("location");
									landmark_list[a] = json_data.getString("landmark");
									type_list[a] = json_data.getString("type");
									status_list[a] = json_data.getString("status");
									date_list[a] = json_data.getString("date");
									String progress1;
									int status = Integer.parseInt(status_list[a]);
									if(status==1)
									{
										progress1 = "Completed";
									}
									else
									{
										progress1 = "In progress";
									}
									
									 data.append("<tr> <td>"+location_list[a]+"</td><td>"+landmark_list[a]+"</td>"+"<td>"+type_list[a]+
											 "</td>"+"<td>"+progress1+"</td>"+"</td>"+"<td>"+date_list[a]+"</td>"+"</tr>");
							    }
								data.append("</table></body></html>");
						    	engine.loadData(data.toString(), "text/html", "UTF-8");
						}
						else
						{
							alert.showAlertDialog(View_complaints.this, "Data not available...", "No complaint is register by you", false);
						}
			 
			
		
		   }catch(SocketTimeoutException e)
					{
						Log.e("Got_ID", ""+e.getMessage());
						alert.showAlertDialog(View_complaints.this, "Timeout...", "Check internet connection", false);
					}
					catch (UnknownHostException e)
					{
						Log.e("Got_ID", ""+e.getMessage());
						alert.showAlertDialog(View_complaints.this, "Unable to resolve Host..", "Check internet connection", false);
					}
					catch (Exception e) 
					{
						Log.e("Got_ID", ""+e.getMessage());
						alert.showAlertDialog(View_complaints.this, "Unable to resolve Host..", ""+e.getMessage(), false);
						e.printStackTrace();
					}
	}

}
