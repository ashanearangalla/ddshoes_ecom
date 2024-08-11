namespace ddApp.Models
{
    public class MainStock
    {
        public int MainStockID { get; set; }
        public int ProductID { get; set; } 
        public int Quantity { get; set; }
        public int Sold { get; set; } 
        public int Remaining => Quantity - Sold; 

      
        public Product Product { get; set; }
    }
}