package com.project.captchit2;

import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;

import com.project.commonUtility.AlertDialogManager;
import com.project.commonUtility.CustomHttpClient;
import com.project.commonUtility.SessionManager;

import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.Toast;

@TargetApi(Build.VERSION_CODES.GINGERBREAD)
public class Civil_Activity extends Activity implements OnClickListener
{

	String path,File_Name;
	Button btnRoad,btnWater_supply,btnDrainage,btnGarbage,btnPublic_Walfare;
	
	String username,mobileno,landmark,location_address;
	double longitude,lattitud;
	
	int serverResponseCode = 0;
	String upLoadServerUri = null;
	ProgressDialog dialog = null;
	AlertDialogManager alert;
	String url="http://103.12.211.176/~captchit/civil_postdata.php";
	
	SessionManager session;
	HashMap<String, String>map;
	ArrayList<NameValuePair>postParameters;
	
	@TargetApi(Build.VERSION_CODES.GINGERBREAD)
	@SuppressLint("NewApi")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		if (android.os.Build.VERSION.SDK_INT > 9)
	        StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().detectDiskReads().detectDiskWrites().detectNetwork().penaltyLog().build());
		setContentView(R.layout.civil_activity);
		
		Bundle extras = getIntent().getExtras();
		if (extras != null) {
			alert = new AlertDialogManager();
		    path = extras.getString("filepath");
		    File_Name = extras.getString("file_name");
		    landmark = extras.getString("landmark");
		    location_address = extras.getString("location");
		    longitude = extras.getDouble("longitude"); 
		    lattitud =  extras.getDouble("lattitude");
		    init();
		}
	}

	private void init() {
		
		
		// TODO Auto-generated method stub
		btnRoad = (Button)findViewById(R.id.btnRoad);
		btnWater_supply = (Button)findViewById(R.id.btnWaterSupply);
		btnDrainage = (Button)findViewById(R.id.btnDrainage);
		btnGarbage = (Button)findViewById(R.id.btnGarbage);
		btnPublic_Walfare = (Button)findViewById(R.id.btnPublic);
		
		btnRoad.setOnClickListener(this);
		btnWater_supply.setOnClickListener(this);
		btnDrainage.setOnClickListener(this);
		btnGarbage.setOnClickListener(this);
		btnPublic_Walfare.setOnClickListener(this);
		
		/**
		 * initialize data to post
		 */
		session = new SessionManager(this);
		map=session.getUserDetails();
		username = map.get(SessionManager.KEY_NAME);
		mobileno = map.get(SessionManager.KEY_MOBILE_NO);
		
		postParameters=new ArrayList<NameValuePair>();
		postParameters.add(new BasicNameValuePair("name", username));
		postParameters.add(new BasicNameValuePair("mobileno", mobileno));
		postParameters.add(new BasicNameValuePair("landmark", landmark));
		postParameters.add(new BasicNameValuePair("location", location_address));
		postParameters.add(new BasicNameValuePair("lat", String.valueOf(lattitud)));
		postParameters.add(new BasicNameValuePair("longi", String.valueOf(longitude)));
		postParameters.add(new BasicNameValuePair("imgname", File_Name));
	}

	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub
		
		switch(v.getId())
		{
		
		case R.id.btnRoad:
			postParameters.add(new BasicNameValuePair("type", "Road Complaint"));
			try {
						dialog = ProgressDialog.show(Civil_Activity.this, "",
								"Uploading file...", true);
				CustomHttpClient.executeHttpPost(url, postParameters);
				uploadFile(path);
				dialog.dismiss();
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			break;
			
		case R.id.btnWaterSupply:
			postParameters.add(new BasicNameValuePair("type", "Water Supply"));
			try {
				CustomHttpClient.executeHttpPost(url, postParameters);
				uploadFile(path);
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			break;
			
		case R.id.btnDrainage:
			postParameters.add(new BasicNameValuePair("type", "Drainage"));
			try {
				CustomHttpClient.executeHttpPost(url, postParameters);
				uploadFile(path);
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			break;
			
		case R.id.btnGarbage:
			postParameters.add(new BasicNameValuePair("type", "Garbage"));
			try {
				CustomHttpClient.executeHttpPost(url, postParameters);
				uploadFile(path);
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			break;
			
		case R.id.btnPublic:
			postParameters.add(new BasicNameValuePair("type", "Public Walfare"));
			try {
				CustomHttpClient.executeHttpPost(url, postParameters);
				uploadFile(path);
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			break;
		}
		
	}

	
	/**
	 * UploadImage Code
	 * @param sourceFileUri
	 * @return
	 */
	public int uploadFile(String sourceFileUri) 
    {
        
				dialog = ProgressDialog.show(Civil_Activity.this, "wait...","Uploading file", true);
		 
        String fileName = sourceFileUri;
        upLoadServerUri="http://103.12.211.176/~captchit/UploadToServer_Civil.php";
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
                     Toast.makeText(Civil_Activity.this, "Source File not exist : "+path, Toast.LENGTH_LONG).show();
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
                               
//                              String msg = "http://103.12.211.176/~captchit/index2.php";
//                              alert.showAlertDialog(Civil_Activity.this, "File Upload Completed, See uploaded file here :", msg, true);
                        	  Intent thankscreen= new Intent(Civil_Activity.this,Thanku_Screen.class);
                        	  startActivity(thankscreen);
                        	  finish();
                        try {
//								postData();
							} catch (Exception e) {
								Toast.makeText(Civil_Activity.this, "Error in post data : "+e.getMessage(),
                                        Toast.LENGTH_SHORT).show();
								e.printStackTrace();
							}
                              
                              Toast.makeText(Civil_Activity.this, "File Upload Complete.",
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
                        Toast.makeText(Civil_Activity.this, "MalformedURLException",
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
                        Toast.makeText(Civil_Activity.this, "Got Exception : see logcat ",
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
}
