<template>
    <div>
        <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Import Excel File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="single_product_quote_form">
                                <div class="row my-1">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <span style="color:#151f21;">Length</span>
                                        <small style="color:#151f21;">*</small>
                                        <div class="data border-1  mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; width: 100%; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.length }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <span style="color:#151f21;">Width</span>
                                        <small style="color:#151f21;">*</small>
                                        <div class="data border-1  mt-2 pl-2"
                                            style="border: 1px solid #ccc; min-height: 30px; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.width }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <span style="color:#151f21;">Height</span>
                                        <small style="color:#151f21;">*</small>
                                        <div class="data border-1  mt-2 pl-2"
                                            style="border: 1px solid #ccc; min-height: 30px; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.height }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <span style="color:#151f21;">Quantity</span>
                                        <div class="data border-1  mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.qty }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <span style="color:#151f21;">Color</span>
                                        <div class="data border-1  mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.color }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <span style="color:#151f21;">Paper Type</span>
                                        <div class="data border-1 mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.paper_type
                                            }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span style="color:#151f21;">Box Style</span>
                                        <div class="data border-1 mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.box_type }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span style="color:#151f21;">Additional Information</span>
                                        <div class="data border-1 mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.add_ons }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <span style="color:#151f21;">Box Name</span>
                                        <small style="color:#151f21;">*</small>
                                        <div class="data border-1  mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; width: 100%; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.box_name }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <span style="color:#151f21;">Name</span>
                                        <small style="color:#151f21;">*</small>
                                        <div class="data border-1  mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; width: 100%; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.name }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <span style="color:#151f21;">Email</span>
                                        <small style="color:#151f21;">*</small>
                                        <div class="data border-1  mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; width: 100%; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.email }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <span style="color:#151f21;">Phone</span>
                                        <small style="color:#151f21;">*</small>
                                        <div class="data border-1  mt-2"
                                            style="border: 1px solid #ccc; min-height: 30px; width: 100%; line-height:30px;">
                                            <span style="padding-left:8px; font-size:0.8rem;">{{ dataList.phone }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <span style="color:#151f21;">Message</span>
                                        <div class="data border-1 p-2 mt-2"
                                            style="border: 1px solid #ccc; max-height: 100px; overflow-y: scroll; font-size:0.8rem;">
                                            {{ dataList.specs }}</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>



export default {
    data: () => ({


    }),
    props: [
        'dataList'
    ],
    mounted() {
        console.log('Component mounted.')
    },
    methods:
    {


    },
    created() {


    }
}
</script>

