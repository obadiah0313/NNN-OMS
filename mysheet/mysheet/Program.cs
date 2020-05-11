using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Excel = Microsoft.Office.Interop.Excel;
using Microsoft.VisualStudio.Tools.Applications.Runtime;
using MongoDB.Bson;
using MongoDB.Driver;
using MongoDB.Bson.Serialization;
using MongoDB.Bson.Serialization.Serializers;

namespace mysheet
{
    class Program
    {
        static void Main(string[] args)
        {
            var connectionString = new MongoUrl("mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false");
            MongoClient dbClient = new MongoClient(connectionString);
            //MongoClient dbClient = new MongoClient();
            var database = dbClient.GetDatabase("heroku_0g0g5g6c");
            //var database = dbClient.GetDatabase("NNNdb");
            var cart = database.GetCollection<BsonDocument>("cart");
            var product_colletion = database.GetCollection<BsonDocument>("stock");
            List<string> header = new List<string>();
            var pk = "";
            var file = "";
            var pList = product_colletion.Find(new BsonDocument()).Limit(1).Sort(Builders<BsonDocument>.Sort.Descending("_id")).ToList();
            foreach(var d in pList)
            {
                pk = d["primaryKey"].ToString();
                file = d["filename"].ToString();
                var text = d["header"].ToString();
                text = text.Substring(1, text.Length - 2);
                header = text.Replace(", ", ",").Split(',').ToList();
            }

            var indexPK = header.IndexOf(pk) + 1;
            var indexQty = 0;
            foreach (var h in header)
            {
                if (h.ToLower().Contains("quantity"))
                {
                    indexQty = header.IndexOf(h) + 1;
                }
            }

            var filter = Builders<BsonDocument>.Filter.Eq("status", "processing");
            var document = cart.Find(filter).ToList();
            List<Dictionary<string, object>> aproduct = new List<Dictionary<string, object>>();
            Dictionary<string, int> product = new Dictionary<string, int>();
            foreach (BsonDocument doc in document)
            {
                var test = doc["carts"].ToBsonDocument();
                aproduct.Add(test.ToDictionary());
            }

            foreach (var d in aproduct)
            {
                foreach (var k in d)
                {
                    if (product.ContainsKey(k.Key))
                    {
                        product[k.Key] = (int)product[k.Key] + (int)k.Value; 
                    }
                    else
                    {
                        product.Add(k.Key, (int)k.Value);
                    }

                }
            }

            update_excel(file, indexPK,indexQty, product);
         }

        public static void update_excel(string file, int primary, int qty, Dictionary<string, int> dict)
        {
            Microsoft.Office.Interop.Excel.Application excel = new Microsoft.Office.Interop.Excel.Application();
            Microsoft.Office.Interop.Excel.Workbook sheet = excel.Workbooks.Open("https://nnn-oms.herokuapp.com/Product_List/" + file);
            Microsoft.Office.Interop.Excel.Worksheet x = excel.Sheets["GBD_Asia"] as Microsoft.Office.Interop.Excel.Worksheet;
            Excel.Range userrange = x.UsedRange;
            int countRecords = userrange.Rows.Count;
            for (int row = 2; row <= countRecords; row++)
            {
                foreach (var item in dict)
                {
                    if (x.Cells[row, primary].Value == item.Key)
                    {
                        x.Cells[row, qty] = item.Value;
                    }
                }
            }
            Excel.Range rng = x.Cells[2, primary];
            rng.Select();
            sheet.Close(true, Type.Missing, Type.Missing);
            excel.Quit();
        }
    }
}
