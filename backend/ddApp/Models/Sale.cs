namespace ddApp.Models
{
    public class Sale
    {
        public int SaleID { get; set; }
        public int SubStockID { get; set; } 
        public int Quantity { get; set; }
        public DateTime SaleDate { get; set; }

        public SubStock SubStock { get; set; }
    }
}