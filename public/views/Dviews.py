from django.shortcuts import get_object_or_404,render,redirect,HttpResponse
from .models import *
from life.constants import *
import time
from annoying.decorators import ajax_request
from django.forms import ModelForm,Form,modelform_factory
import pdb
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login


@ajax_request
def funders(request):
    #NEED TO USE SESSION ID TO GET THE GOD EVERYWHERE.
    prods= Product.objects.all()
    prods_units = [entry.num_units for entry in prods]
    # HttpResponse(json.dumps(resp), mimetype='application/json')#
    return {'prods_units': prods_units}   #this is an object, access with a dot !

def manage_product(request, god_id):
    # myForm = modelform_factory(Product, fields=('product_name',))
    user_god = get_object_or_404(God,pk=god_id)
    if request.method == "POST":
        form = ProductForm(request.POST)
        if form.is_valid():
            curr_p = form.save(commit=False) #Save all but empty fields
            price = calculatePrice(curr_p)
            #FIRST VALIDATE BEFORE LOOSING LE
            if(curr_p.valid_create(price,user_god)):
                curr_p.being_funded = True
                curr_p.owner_god = user_god
                user_god.looseLE(price)
                curr_p.save()
                return redirect('./'+god_id) ##CHANGE THIS LATER !
