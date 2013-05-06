using System;
using System.Web;
using System.IO;
using MySql.Data.MySqlClient;
namespace IntranetServicesWebsite
{
    public class RewritePathModule : IHttpModule
    {
        public void Init(HttpApplication app)
        {
            app.BeginRequest += new EventHandler(Rewrite);
        }

        public void Dispose()
        {

        }
        private void Rewrite(object sender, EventArgs e)
        {
            
            HttpContext context = ((HttpApplication)sender).Context;
            string urlabsolutepath=context.Request.Url.AbsolutePath;
            
            if (!urlabsolutepath.StartsWith("/resources", true, null))
            {
                if (!urlabsolutepath.StartsWith("/applications", true, null))
                {
                    FileAttributes attr;
                    try
                    {
                        attr = File.GetAttributes(@context.Request.PhysicalApplicationPath+"/Applications"+urlabsolutepath);
                    }
                    catch
                    {
                        attr = FileAttributes.Normal;
                    }

                    if ((attr & FileAttributes.Directory) == FileAttributes.Directory)
                    {
                        if (!urlabsolutepath.EndsWith("/", true, null))
                        {
                            context.Response.Redirect(urlabsolutepath + "/" + context.Request.Url.Query);
                        }
                        else
                        {
                            context.RewritePath("~/Applications/" + urlabsolutepath, context.Request.PathInfo, context.Request.Url.Query);
                        }
                    }
                    else
                    {
                        
                        context.RewritePath("~/Applications/" + context.Request.Url.PathAndQuery);
                    }
                }
            }
            //context.Response.Write(context.Request.Url.AbsolutePath.StartsWith("/applications/login",true,null));
            // ((HttpApplication)sender).Context.Response.Write(token_no.Value);
        }
    }
}