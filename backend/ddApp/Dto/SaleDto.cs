namespace ddApp.Dto
{
    public class SaleDto
    {
        public int SaleID { get; set; }
        public int SubStockID { get; set; } // Foreign key to SubStock
        public int Quantity { get; set; }
        public DateTime SaleDate { get; set; }
    }
}
