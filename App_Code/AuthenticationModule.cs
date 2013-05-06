using System;
using System.Web;
using System.IO;
using MySql.Data.MySqlClient;
namespace IntranetServicesWebsite
{
    public class AuthenticationModule : IHttpModule
    {
        public void Init(HttpApplication app)
        {
            app.BeginRequest += new EventHandler(Authenticate);
        }

        public void Dispose()
        {

        }
        private void Authenticate(object sender, EventArgs e)
        {            
            HttpContext context = ((HttpApplication)sender).Context;
            if (!context.Request.Url.AbsolutePath.StartsWith("/resources", true, null))
            {
                bool authentic = false;
                HttpCookieCollection cookies = context.Request.Cookies;
                HttpCookie token_no = cookies["token_no"];
                HttpCookie uuid = cookies["uuid"];

                if (token_no != null)
                {
                    MySqlConnection conn = new MySqlConnection("Server=127.0.0.1;Database=information services website;Uid=root;Pwd=sql_sre!;");
                    conn.Open();

                    MySqlCommand cmd = new MySqlCommand("SELECT uuid,expiry_time FROM login WHERE token_no='" + token_no.Value + "' ORDER BY token_no DESC LIMIT 1", conn);
                    MySqlDataReader rdr = cmd.ExecuteReader();
                    while (rdr.Read())
                    {
                        DateTime expiry_time = DateTime.Parse(rdr.GetString(1));
                        if (rdr.GetString(0) == uuid.Value && DateTime.Compare(expiry_time, DateTime.Now) > 0)
                        {
                            
                            authentic = true;
                        }
                    }
                    rdr.Close();
                    conn.Close();
                    
                }
                if (!authentic && !context.Request.Url.AbsolutePath.StartsWith("/applications/authentication/login", true, null))
                {
                    context.Response.Redirect("~/Authentication/Login/",false);
                }
                else if (authentic && context.Request.Url.AbsolutePath.StartsWith("/applications/authentication/login", true, null))
                {
                    
                    context.Response.Redirect("~/Home/",false);
                }
            }

            /*StreamWriter writ4 = new StreamWriter("C:/v/vshn_loggedin.txt", true);
            writ4.WriteLine(context.Request.Url.AbsolutePath);
            writ4.Close();*/
            //context.Response.Write(context.Request.Url.AbsolutePath.StartsWith("/applications/login",true,null));
           // ((HttpApplication)sender).Context.Response.Write(token_no.Value);
        }
    }
}