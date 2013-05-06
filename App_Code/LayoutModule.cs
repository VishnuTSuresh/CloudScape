using System;
using System.Web;
using System.IO;
using System.Text.RegularExpressions;
using System.Xml;

namespace IntranetServicesWebsite
{
    public class LayoutModule : IHttpModule
    {
        const string content = "#ISW:CONTENT",leftbar="#ISW:LEFTBAR";

        public void Init(HttpApplication app)
        {
            app.BeginRequest += new EventHandler(OnBeginRequest);
            app.EndRequest += new EventHandler(OnEndRequest);
        }

        public void Dispose()
        {

        }
        public void OnBeginRequest(object sender, EventArgs e)
        {
            if (!((HttpApplication)sender).Context.Request.Url.AbsolutePath.StartsWith("/resources", true, null))
            {
                System.IO.StreamReader myFile = new System.IO.StreamReader(HttpRuntime.AppDomainAppPath + "/resources/layout.html");
                string myString = myFile.ReadToEnd();
                myFile.Close();
                string[] parts = Regex.Split(myString, content);
                string PageHeader = parts[0];
                HttpApplication app = (HttpApplication)sender;
                HttpContext ctx = app.Context;
                try
                {
                    ctx.Response.Write(PageHeader);
                }
                catch (Exception ex)
                {
                    ctx.Response.Write(ex.Message);
                }
            }
        }
        public void OnEndRequest(object sender, EventArgs e)
        {
            if (!((HttpApplication)sender).Context.Request.Url.AbsolutePath.StartsWith("/resources", true, null))
            {
                System.IO.StreamReader myFile = new System.IO.StreamReader(HttpRuntime.AppDomainAppPath + "/resources/layout.html");
                string myString = myFile.ReadToEnd();
                myFile.Close();
                string[] parts = Regex.Split(myString, content);
                string PageFooter = parts[1];
                HttpApplication app = (HttpApplication)sender;
                HttpContext ctx = app.Context;
                if (ctx.Response.StatusCode == 200)
                {
                    XmlDocument layout = new XmlDocument();
                    XmlDocument document = new XmlDocument();
                    layout.Load(@HttpRuntime.AppDomainAppPath+"/resources/layout.xml");
                    XmlNodeList groups = layout.SelectNodes("layout/leftbar/group");
                    XmlElement leftbarcontainer=document.CreateElement("div");
                    foreach (XmlNode group in groups)
                    {
                        XmlElement groupHTML = document.CreateElement("div");
                        XmlElement groupName = document.CreateElement("div");
                        groupName.InnerText = group.Attributes["name"].Value;
                        groupHTML.AppendChild(groupName);
                        XmlNodeList entries = group.SelectNodes("entry");
                        foreach (XmlNode entry in entries)
                        {
                            XmlElement entryHTML = document.CreateElement("div");
                            XmlElement entryLinkHTML = document.CreateElement("a");
                            entryLinkHTML.InnerText = entry.InnerText;
                            entryLinkHTML.SetAttribute("href",entry.Attributes["url"].Value);
                            entryHTML.AppendChild(entryLinkHTML);
                            groupHTML.AppendChild(entryHTML);
                        }
                        leftbarcontainer.AppendChild(groupHTML);
                    }
                    
                    using (var stringWriter = new StringWriter())
                    using (var xmlTextWriter = XmlWriter.Create(stringWriter))
                    {
                        leftbarcontainer.WriteTo(xmlTextWriter);
                        xmlTextWriter.Flush();
                        
                        ctx.Response.Write(PageFooter.Replace(leftbar, stringWriter.GetStringBuilder().ToString()));
                    }
                    
                }
            }
        }
    }
}
