namespace ddApp.Dto
{
    public class SubStockDto
    {
        public int SubStockID { get; set; }
        public int ProductID { get; set; } // Foreign key to Product
        public int UserID { get; set; } // Foreign key to Outlet
        public int Quantity { get; set; } // Total quantity available
        public int Sold { get; set; } // Quantity sold
    }
}
