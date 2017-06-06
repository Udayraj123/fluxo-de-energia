class Seed(models.Model):
    def complete_growth(self,sell_price,farmer_id):
        fruit = Fruit()
        fruit.num_fruits = self.num_seeds
        fruit.storage_LE = self.storage_LE
        fruit.sell_price = sell_price
        ret_fac=0.05
        farmer= get_object_or_404(Farmer, pk=farmer_id)
        farmer.inc_LE(ret_fac * self.storage_LE)
        fruit.save()
        #Plus update this in the land grid.
        #Clicking on that land shall add Fruit to sell menu & reset the land block

class Fruit(models.Model):
    storage_LE =models.PositiveIntegerField()
    num_units=models.PositiveIntegerField()

    expiry_time = models.PositiveIntegerField()

    sell_price  =  models.PositiveIntegerField()
    description = models.CharField(max_length=300)
    fruit_type = models.CharField(max_length=300)


#decrease GT
class Fertilizer(Product):
    quality_factor = 1.2
    def ACTION(self,seed):
        seed.growth_time /= self.quality_factor

# Has HIGHER LE return.
class SplSeed(Product):
    quality_factor=1.4
    def ACTION(self,seed):
        seed.storage_LE *= self.quality_factor

# Increase num_land_units
class LandPiece(Product):
    inc_num=4
    def ACTION(self,land):
        land.num_units += inc_num
        
class ProductForm (ModelForm):
    class Meta:
        model = Product
        # fields=CREATE_PRODUCT_FIELDS
        exclude = ['time_when_created','being_funded','owner_god','funding_investors']        # fields = '__all__'
# fields = ['product_name', 'owner_god', 'product_type', 'product_quality', 'description', 'product_ET', 'product_FT']
