package com.project.captchit2;

import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.SocketTimeoutException;
import java.net.URL;
import java.net.UnknownHostException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;

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
import android.graphics.Bitmap;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.Toast;

import com.project.commonUtility.AlertDialogManager;
import com.project.commonUtility.ConnectionDetector;
import com.project.commonUtility.CustomHttpClient;
import com.project.commonUtility.GPSTracker;
import com.project.commonUtility.SessionManager;

@TargetApi(Build.VERSION_CODES.GINGERBREAD)
@SuppressLint("NewApi")
public class MainActivity extends Activity implements OnClickListener, OnItemClickListener, OnItemSelectedListener {

	Button btnAccident,btnMedical,btnCrime,btnFire,btnElectricity,btncivilIssue;
	AutoCompleteTextView actv;
	private ArrayAdapter<String> arrayadp;
	
	String landmark_List[];
	
	Bitmap bmp1;
	String path,File_Name,selectedLandmark;
	
	String username,mobileno;
	
	GPSTracker gps;
	SessionManager session;
	AlertDialogManager alert;
	HashMap<String, String>map;
	ArrayList<NameValuePair>postParameters,postLandmark;
	double longitude;
	double lattitude;
	String location_address ="";
	//URL to postdata.php on desired server
	String url="http://103.12.211.176/~captchit/postdata.php";
	//URL to Return_landmark.php on desired server
	String landmark_URL="http://103.12.211.176/~captchit/Return_Landmark.php";
	int serverResponseCode = 0;
	ProgressDialog dialog = null;
	String upLoadServerUri = null;
	String response;
	
	@TargetApi(Build.VERSION_CODES.GINGERBREAD)
	@SuppressLint("NewApi")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		if (android.os.Build.VERSION.SDK_INT > 9)
	        StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().detectDiskReads().detectDiskWrites().detectNetwork().penaltyLog().build());
		
		setContentView(R.layout.activity_main);
		
        
		alert = new AlertDialogManager();
		session = new SessionManager(this);
		gps=new GPSTracker(this);
		map=session.getUserDetails();
		username = map.get(SessionManager.KEY_NAME);
		mobileno = map.get(SessionManager.KEY_MOBILE_NO);
		
		
		Bundle extras = getIntent().getExtras();
		if (extras != null) {
		    path = extras.getString("filepath");
		    File_Name = extras.getString("file_name");
		}
		
		init();
		
		
		

		
	}

	private void init() {
		// TODO Auto-generated method stub
		/**
		 * initialize data for autto complete text
		 */
		String imei;
		TelephonyManager tm = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
		imei= tm.getDeviceId();
		postLandmark=new ArrayList<NameValuePair>();
		postLandmark.add(new BasicNameValuePair("imei", imei));
		
		Executelandmarks(landmark_URL);
		
		/**
		 * initialize view
		 */
		btnAccident=(Button)findViewById(R.id.btnAccident);
		btnMedical=(Button)findViewById(R.id.btnMedical);
		btnCrime=(Button)findViewById(R.id.btnCrime);
		btnFire=(Button)findViewById(R.id.btnFire);
		btnElectricity=(Button)findViewById(R.id.btnElectricity);
		btncivilIssue=(Button)findViewById(R.id.btnCivil);
		actv=(AutoCompleteTextView)findViewById(R.id.autocompleteTV);
		
		btnAccident.setOnClickListener(this);
		btnMedical.setOnClickListener(this);
		btnCrime.setOnClickListener(this);
		btnFire.setOnClickListener(this);
		btnElectricity.setOnClickListener(this);
		btncivilIssue.setOnClickListener(this);
		
		
		/**
		 * AutoText
		 */
		arrayadp=new ArrayAdapter<String>(MainActivity.this, android.R.layout.simple_dropdown_item_1line, landmark_List);
		actv.setAdapter(arrayadp);
		//actv.setOnItemSelectedListener(this);
		actv.setOnItemClickListener(this);
		
		/**
		 * get current location
		 */
		ConnectionDetector cd = new ConnectionDetector(this);
		
		if(cd.isConnectingToInternet())
		{
			try {
				Location l; 
				l=gps.getLocation();
				 longitude = gps.getLongitude();
				 lattitude = gps.getLatitude();
				Log.e("gps","-->"+ l+ "--->Longitude :"+longitude +" Lattitude :"+lattitude);
				
						
						try{
							 Geocoder geo = new Geocoder(MainActivity.this.getApplicationContext(), Locale.getDefault());
							 List<Address> addresses = geo.getFromLocation(lattitude, longitude, 1);
							  if (addresses.isEmpty()) {
								  alert.showAlertDialog(MainActivity.this, "Can not Get Your Location", "Check Your Internet Service...", false);
							  }
//						  else {
							     if (addresses.size() > 0) {       
							        Log.d("gps",addresses.get(0).getFeatureName() + ","
							          + addresses.get(0).getLocality()+", " 
							          + addresses.get(0).getAdminArea() + "," 
							          + addresses.get(0).getCountryName());
							        location_address= addresses.get(0).getFeatureName() + ","
							        		  + addresses.get(0).getThoroughfare()+", "
									          + addresses.get(0).getSubLocality()+", " 
									          + addresses.get(0).getLocality()+", "
									          + addresses.get(0).getAdminArea() + "," 
									          + addresses.get(0).getCountryName() +"-"
									          + addresses.get(0).getPostalCode();
							        Toast.makeText(MainActivity.this, "Your location is : "+location_address, Toast.LENGTH_LONG).show();
							     }
//						  }
							}
							catch (Exception e) {
							    e.printStackTrace(); 
							}
			} catch (Exception e) {
				// TODO Auto-generated catch block
				alert.showAlertDialog(MainActivity.this, "Location Error", "Cant get location!!!!", false);
			}
		}
		else
		{
			
			alert.showAlertDialog(MainActivity.this, "Can not Get Your Location", "Check Your Internet Service...", false);
		}
		/**
		 * initialize data to post
		 */
		postParameters=new ArrayList<NameValuePair>();
		postParameters.add(new BasicNameValuePair("name", username));
		postParameters.add(new BasicNameValuePair("mobileno", mobileno));
		postParameters.add(new BasicNameValuePair("location", location_address));
		postParameters.add(new BasicNameValuePair("lat", String.valueOf(lattitude)));
		postParameters.add(new BasicNameValuePair("longi", String.valueOf(longitude)));
		postParameters.add(new BasicNameValuePair("landmark", "Currently Not Selected"));
		postParameters.add(new BasicNameValuePair("imgname", File_Name));
		
	}

	
	/**
	 * onclick Events
	 */
	
	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub
		
//		if (!actv.getText().toString().equals("") || !actv.getText().toString().equals(null)) 
			if (!actv.getText().toString().matches("")){
			switch (v.getId()) {

			case R.id.btnAccident:
				postParameters.add(new BasicNameValuePair("type", "Accident"));

				try {
					if (checkLandMark()) {
						CustomHttpClient.executeHttpPost(url, postParameters);
						uploadFile(path);
					}else
					{
						alert.showAlertDialog(MainActivity.this, "incorrect Landmark...", "Please Enter Valid LandMark First...", false);
					}
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				break;

			case R.id.btnMedical:
				postParameters.add(new BasicNameValuePair("type","Medical Emergency"));
				try {
					if (checkLandMark()) {
						CustomHttpClient.executeHttpPost(url, postParameters);
						uploadFile(path);
					}else
					{
						alert.showAlertDialog(MainActivity.this, "incorrect Landmark...", "Please Enter Valid LandMark First...", false);
					}
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				break;

			case R.id.btnCrime:
				postParameters.add(new BasicNameValuePair("type", "Crime Activity"));
				try {
					if (checkLandMark()) {
						CustomHttpClient.executeHttpPost(url, postParameters);
						uploadFile(path);
					}else
					{
						alert.showAlertDialog(MainActivity.this, "incorrect Landmark...", "Please Enter Valid LandMark First...", false);
					}
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				break;

			case R.id.btnFire:
				postParameters.add(new BasicNameValuePair("type", "Fire"));

				try {
					if (checkLandMark()) {
						CustomHttpClient.executeHttpPost(url, postParameters);
						uploadFile(path);
					}else
					{
						alert.showAlertDialog(MainActivity.this, "incorrect Landmark...", "Please Enter Valid LandMark First...", false);
					}
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				break;

			case R.id.btnElectricity:
				postParameters
						.add(new BasicNameValuePair("type", "Electric Problem"));
				try {
					if (checkLandMark()) {
						CustomHttpClient.executeHttpPost(url, postParameters);
						uploadFile(path);
					}else
					{
						alert.showAlertDialog(MainActivity.this, "incorrect Landmark...", "Please Enter Valid LandMark First...", false);
					}
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				break;

			case R.id.btnCivil:
				if (checkLandMark()) {
					Intent i = new Intent(MainActivity.this,
							Civil_Activity.class);
					i.putExtra("filepath", path);
					i.putExtra("file_name", File_Name);
					i.putExtra("landmark", selectedLandmark);
					i.putExtra("location", location_address);
					i.putExtra("longitude", longitude);
					i.putExtra("lattitude", lattitude);
					startActivity(i);
					finish();
				}else
				{
					alert.showAlertDialog(MainActivity.this, "incorrect Landmark...", "Please Enter Valid LandMark First...", false);
				}
				break;
			}
		}
		else
		{
			alert.showAlertDialog(MainActivity.this, "Enter Landmark!!!", "Please Enter Landmark First then proceed", false);
		}
	}
	

	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

	
	/**
	 * Methods for Auto complete Text
	 * @param arg0
	 * @param arg1
	 * @param arg2
	 * @param arg3
	 */
	@Override
	public void onItemSelected(AdapterView<?> arg0, View arg1, int arg2,
			long arg3) {
		// TODO Auto-generated method stub
		InputMethodManager imm = (InputMethodManager) getSystemService(INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(),0);
	}

	@Override
	public void onNothingSelected(AdapterView<?> arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
		// TODO Auto-generated method stub
		/**
		 * selected landmark select
		 */
		postParameters.remove(new BasicNameValuePair("landmark", "Currently Not Selected"));
		selectedLandmark = ""+parent.getItemAtPosition(position);
		postParameters.add(new BasicNameValuePair("landmark", selectedLandmark));
		Log.e("gps", "Landmark is : "+parent.getItemAtPosition(position));
	}

	

	/**
	 * UploadImage Code
	 * @param sourceFileUri
	 * @return
	 */
	public int uploadFile(String sourceFileUri) 
    {
        
				dialog = ProgressDialog.show(MainActivity.this, "",
						"Uploading file...", true);
        String fileName = sourceFileUri;
        upLoadServerUri="http://103.12.211.176/~captchit/UploadToServer1.php";
        HttpURLConnection conn = null;
        DataOutputStream dos = null; 
        String lineEnd = "\r\n";
        String twoHyphens = "--";
        String boundary = "*****";
        int bytesRead, bytesAvailable, bufferSize;
        byte[] buffer;
        int maxBufferSize = 1 * 1024 * 1024;
        File sourceFile = new File(sourceFileUri);
         
        if (!sourceFile.isFile()) {
             
             
              
             runOnUiThread(new Runnable() {
                 @Override
				public void run() {
                	 dialog.dismiss(); 
                     Toast.makeText(MainActivity.this, "Source File not exist : "+path, Toast.LENGTH_LONG).show();
                 }
             });
              
             return 0;
          
        }
        else
        {
             try {
                  
                   // open a URL connection to the Servlet
                 FileInputStream fileInputStream = new FileInputStream(sourceFile);
                 URL url = new URL(upLoadServerUri);
                  
                 // Open a HTTP  connection to  the URL
                 conn = (HttpURLConnection) url.openConnection();
                 conn.setDoInput(true); // Allow Inputs
                 conn.setDoOutput(true); // Allow Outputs
                 conn.setUseCaches(false); // Don't use a Cached Copy
                 
                 conn.setRequestMethod("POST");
                 conn.setRequestProperty("Connection", "Keep-Alive");
                 conn.setRequestProperty("ENCTYPE", "multipart/form-data");
                 conn.setRequestProperty("Content-Type", "multipart/form-data;boundary=" + boundary);
                 conn.setRequestProperty("uploaded_file", fileName);
                  
                 dos = new DataOutputStream(conn.getOutputStream());
        
                 dos.writeBytes(twoHyphens + boundary + lineEnd);

                 dos.writeBytes("Content-Disposition: form-data; name=uploaded_file; filename="
                         + File_Name + "" + lineEnd);
                 
                 
                 dos.writeBytes(lineEnd);
        
                 // create a buffer of  maximum size
                 bytesAvailable = fileInputStream.available();
        
                 bufferSize = Math.min(bytesAvailable, maxBufferSize);
                 buffer = new byte[bufferSize];
        
                 // read file and write it into form...
                 bytesRead = fileInputStream.read(buffer, 0, bufferSize); 
                    
                 while (bytesRead > 0) {
                      
                   dos.write(buffer, 0, bufferSize);
                   bytesAvailable = fileInputStream.available();
                   bufferSize = Math.min(bytesAvailable, maxBufferSize);
                   bytesRead = fileInputStream.read(buffer, 0, bufferSize);  
                    
                  }
        
                 // send multipart form data necesssary after file data...
                 dos.writeBytes(lineEnd);
                 dos.writeBytes(twoHyphens + boundary + twoHyphens + lineEnd);
        
                 // Responses from the server (code and message)
                 serverResponseCode = conn.getResponseCode();
                 String serverResponseMessage = conn.getResponseMessage();
                   
                 Log.i("uploadFile", "HTTP Response is : "
                         + serverResponseMessage + ": " + serverResponseCode);
                  
                 if(serverResponseCode == 200){
                      
                     runOnUiThread(new Runnable() {
                          @Override
						public void run() {
                               
                        	  
                        	  Intent thankscreen= new Intent(MainActivity.this,Thanku_Screen.class);
                        	  startActivity(thankscreen);
                        	  finish();
                        try {
							} catch (Exception e) {
								Toast.makeText(MainActivity.this, "Error in post data : "+e.getMessage(),
                                        Toast.LENGTH_SHORT).show();
								e.printStackTrace();
							}
                              
                              Toast.makeText(MainActivity.this, "File Upload Complete.",
                                           Toast.LENGTH_SHORT).show();
                          }
                      });               
                 }   
                  
                 //close the streams //
                 fileInputStream.close();
                 dos.flush();
                 dos.close();
                   
            } catch (MalformedURLException e) {
                 
                dialog.dismiss(); 
                e.printStackTrace();
                 
                runOnUiThread(new Runnable() {
                    @Override
					public void run() {
//                        tvStatus.setText("MalformedURLException Exception : check script url.");
                        Toast.makeText(MainActivity.this, "MalformedURLException",
                                                            Toast.LENGTH_SHORT).show();
                    }
                });
                 
                Log.e("Upload file to server", "error: " + e.getMessage(), e); 
            } catch (Exception e) {
                 
                dialog.dismiss(); 
                e.printStackTrace();
                 
                runOnUiThread(new Runnable() {
                    @Override
					public void run() {
//                        tvStatus.setText("Got Exception : see logcat ");
                        Toast.makeText(MainActivity.this, "Got Exception : see logcat ",
                                Toast.LENGTH_SHORT).show();
                    }
                });
                Log.e("Upload file to server Exception", "Exception : "
                                                 + e.getMessage(), e); 
            }
            dialog.dismiss();      
            return serverResponseCode;
             
         } // End else block
       }
	
	
	/**
	 * @author gagandeep
	 */
	public boolean Executelandmarks(String url)
	{

					
					try {
						 
						 response=CustomHttpClient.executeHttpPost(url,postLandmark);
						 String result=response.toString();
						 JSONArray jArray;
						
							 	jArray = new JSONArray(result);
							 	landmark_List= new String[jArray.length()];
									if (jArray.length()>=1) 
									{
										
											/**
											 * initialize array
											 */
											for (int a = 0; a < jArray.length(); a++) 
											{
												JSONObject json_data = jArray.getJSONObject(a);
												landmark_List[a] = json_data.getString("landmark");
										    }
										    return true;
									}
									else
									{
										return false;
									}
						 
						
					
					   }catch(SocketTimeoutException e)
								{
									Log.e("Got_ID", ""+e.getMessage());
									return false;
								}
								catch (UnknownHostException e)
								{
									Log.e("Got_ID", ""+e.getMessage());
									return false;
								}
								catch (Exception e) 
								{
									Log.e("Got_ID", ""+e.getMessage());
									e.printStackTrace();
									return false;
								}
	}
	
	@SuppressWarnings("unused")
	Boolean checkLandMark()
	{
		for(int i=0 ; i<= landmark_List.length; i++)
		{
			if(landmark_List[i].equals(actv.getText().toString()))
			{
				return true;
			}
			else
				return false;
		}
		
		
		return true;
	}
}	
