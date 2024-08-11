namespace ddApp.Dto
{
    public class MainStockDto
    {
        public int MainStockID { get; set; }
        public int ProductID { get; set; } // Foreign key to Product
        public int Quantity { get; set; } // Total quantity of products available
        public int Sold { get; set; } // Quantity sold
    }
}
